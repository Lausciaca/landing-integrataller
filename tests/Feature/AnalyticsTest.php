<?php

namespace Tests\Feature;

use App\Models\AnalyticsEvent;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AnalyticsTest extends TestCase
{
    use RefreshDatabase;

    private const UA = 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 Instagram 350.0';

    private const SESSION = '3f1c2b9a-0d4e-4c55-9a77-111122223333';

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
        Http::fake();
        $this->withoutDefer();
        config([
            'app.url' => 'https://integrataller.com',
            'landing.demo_notification_email' => null,
            'services.integrataller.webhook_url' => null,
            'landing.analytics.meta_pixel_id' => null,
            'landing.analytics.meta_capi_token' => null,
            'landing.analytics.clarity_id' => null,
            'landing.analytics.ga4_id' => null,
        ]);
    }

    private function attribution(array $extra = []): array
    {
        return [
            'session_id' => self::SESSION,
            'landing_page' => '/',
            'referrer' => 'https://l.instagram.com/?u=https%3A%2F%2Fintegrataller.com',
            'utm_source' => 'facebook',
            'utm_medium' => 'paid',
            'utm_campaign' => 'Lanzamiento octubre',
            'utm_content' => 'Video taller',
            'click_id' => 'fbclid',
            'fbclid' => 'IwAR123',
            ...$extra,
        ];
    }

    private function beacon(array $payload, string $ua = self::UA, array $cookies = [])
    {
        return $this->call('POST', '/api/t', [], $cookies, [], [
            'CONTENT_TYPE' => 'text/plain',
            'HTTP_USER_AGENT' => $ua,
            'REMOTE_ADDR' => '200.10.20.30',
        ], json_encode($payload));
    }

    private function consentCookie(bool $marketing): array
    {
        return ['it_consent' => 'v1.a1.m'.($marketing ? '1' : '0'), '_fbp' => 'fb.1.1700000000000.123456'];
    }

    public function test_beacon_stores_an_anonymous_event_with_attribution(): void
    {
        $this->beacon(['t' => 'pageview', 'p' => '/servicios?x=1', 'a' => $this->attribution(), 'w' => 390])->assertNoContent();

        $event = AnalyticsEvent::sole();
        $this->assertSame('pageview', $event->type);
        $this->assertSame('/servicios', $event->path);
        $this->assertSame(self::SESSION, $event->session_id);
        $this->assertSame('l.instagram.com', $event->referrer_host);
        $this->assertSame('Lanzamiento octubre', $event->utm_campaign);
        $this->assertSame('fbclid', $event->click_id);
        $this->assertSame('mobile', $event->device);
        $this->assertSame('Instagram', $event->browser);
        $this->assertSame('iOS', $event->os);
        $this->assertSame(16, strlen($event->visitor_hash));
        $this->assertStringNotContainsString('200.10.20.30', json_encode($event->getAttributes()));
    }

    public function test_bots_unknown_types_and_invalid_values_are_ignored(): void
    {
        $this->beacon(['t' => 'pageview', 'p' => '/', 'a' => $this->attribution()], 'Mozilla/5.0 (compatible; Googlebot/2.1)')->assertNoContent();
        $this->beacon(['t' => 'purchase', 'p' => '/', 'a' => $this->attribution()])->assertNoContent();
        $this->beacon(['t' => 'pageview', 'p' => 'https://evil.test', 'a' => $this->attribution()])->assertNoContent();
        $this->beacon(['t' => 'pageview', 'p' => '/', 'a' => ['session_id' => 'x']])->assertNoContent();
        $this->assertSame(0, AnalyticsEvent::count());

        $this->beacon(['t' => 'scroll', 'p' => '/', 'a' => $this->attribution(), 'v' => 33])->assertNoContent();
        $this->beacon(['t' => 'engagement', 'p' => '/', 'a' => $this->attribution(), 'v' => 99999])->assertNoContent();
        $this->assertNull(AnalyticsEvent::where('type', 'scroll')->value('value'));
        $this->assertSame(3600, AnalyticsEvent::where('type', 'engagement')->value('value'));
    }

    public function test_browsing_beacons_do_not_use_up_the_demo_form_rate_limit(): void
    {
        foreach (range(1, 15) as $i) {
            $this->beacon(['t' => 'scroll', 'p' => '/', 'a' => $this->attribution(), 'v' => 25])->assertNoContent();
        }

        $this->post('/contacto', [
            'name' => 'Juan Pérez', 'taller' => 'Taller Central', 'phone' => '3364006452', 'email' => 'juan@example.test',
        ], ['REMOTE_ADDR' => '200.10.20.30'])->assertRedirect(route('demo.thank-you'));
    }

    public function test_same_visitor_gets_the_same_daily_hash(): void
    {
        $this->beacon(['t' => 'pageview', 'p' => '/', 'a' => $this->attribution()]);
        $this->beacon(['t' => 'pageview', 'p' => '/contacto', 'a' => $this->attribution()]);

        $this->assertSame(1, AnalyticsEvent::distinct()->count('visitor_hash'));
    }

    public function test_demo_request_saves_attribution_and_records_the_conversion(): void
    {
        $this->post('/contacto', [
            'name' => 'Juan Pérez', 'taller' => 'Taller Central', 'phone' => '0336 15 400-6452',
            'email' => 'juan@example.test', 'attribution' => json_encode($this->attribution()),
        ], ['User-Agent' => self::UA])->assertRedirect(route('demo.thank-you'))
            ->assertSessionHas('conversion', fn (array $conversion) => $conversion['meta'] === 'Lead');

        $contact = Contact::sole();
        $this->assertSame(self::SESSION, $contact->session_id);
        $this->assertSame('Lanzamiento octubre', $contact->utm_campaign);
        $this->assertSame('Video taller', $contact->utm_content);
        $this->assertSame('l.instagram.com', $contact->referrer_host);
        $this->assertNotNull($contact->meta_event_id);
        $this->assertDatabaseHas('analytics_events', ['type' => 'demo_submit', 'session_id' => self::SESSION, 'utm_campaign' => 'Lanzamiento octubre']);

        // Sin Pixel configurado no se llama a Meta.
        Http::assertNothingSent();
    }

    public function test_conversions_api_sends_a_hashed_lead_only_with_advertising_consent(): void
    {
        config([
            'landing.analytics.meta_pixel_id' => '1234567890',
            'landing.analytics.meta_capi_token' => 'capi-secret',
            'landing.analytics.meta_test_event_code' => 'TEST123',
        ]);
        $form = [
            'name' => 'Juan Pérez', 'taller' => 'Taller Central', 'phone' => '0336 15 400-6452',
            'email' => 'JUAN@example.test', 'attribution' => json_encode($this->attribution()),
        ];

        $this->withUnencryptedCookies($this->consentCookie(false))->post('/contacto', $form);
        Http::assertNothingSent();

        $this->withUnencryptedCookies($this->consentCookie(true))->post('/contacto', $form, ['User-Agent' => self::UA]);

        $contact = Contact::latest('id')->first();
        Http::assertSent(function (ClientRequest $request) use ($contact) {
            $event = $request['data'][0];

            return str_starts_with($request->url(), 'https://graph.facebook.com/v24.0/1234567890/events?access_token=capi-secret')
                && $request['test_event_code'] === 'TEST123'
                && $event['event_name'] === 'Lead'
                && $event['event_id'] === $contact->meta_event_id
                && $event['action_source'] === 'website'
                && $event['user_data']['em'] === [hash('sha256', 'juan@example.test')]
                && $event['user_data']['ph'] === [hash('sha256', '5493364006452')]
                && $event['user_data']['fn'] === [hash('sha256', 'juan')]
                && $event['user_data']['fbp'] === 'fb.1.1700000000000.123456'
                && str_ends_with($event['user_data']['fbc'], '.IwAR123')
                && $event['user_data']['client_user_agent'] === self::UA;
        });
        Http::assertSentCount(1);
    }

    public function test_whatsapp_click_is_reported_to_meta_as_contact(): void
    {
        config(['landing.analytics.meta_pixel_id' => '1234567890', 'landing.analytics.meta_capi_token' => 'capi-secret']);

        $this->beacon([
            't' => 'whatsapp_click', 'p' => '/servicios', 'a' => $this->attribution(), 'l' => 'Escribinos por WhatsApp',
            'e' => 'b7a1c2d3-0000-4000-8000-123456789abc',
        ], self::UA, $this->consentCookie(true));

        $this->assertDatabaseHas('analytics_events', ['type' => 'whatsapp_click', 'label' => 'Escribinos por WhatsApp']);
        Http::assertSent(fn (ClientRequest $request) => $request['data'][0]['event_name'] === 'Contact'
            && $request['data'][0]['event_id'] === 'b7a1c2d3-0000-4000-8000-123456789abc'
            && $request['data'][0]['event_source_url'] === url('/servicios'));
    }

    public function test_newsletter_subscription_records_a_conversion(): void
    {
        $this->post(route('newsletter.store'), [
            'subscription_email' => 'lector@example.test',
            'subscription_source' => 'footer',
            'attribution' => json_encode($this->attribution()),
        ], ['User-Agent' => self::UA])->assertSessionHas('conversion', fn (array $c) => $c['meta'] === 'CompleteRegistration');

        $this->assertDatabaseHas('analytics_events', ['type' => 'newsletter_submit', 'label' => 'footer', 'utm_source' => 'facebook']);
    }

    public function test_cookie_banner_and_tags_only_render_when_configured(): void
    {
        $this->get('/')->assertOk()
            ->assertDontSee('data-cookie-banner', false)
            ->assertSee('id="it-analytics"', false);

        config(['landing.analytics.meta_pixel_id' => '1234567890', 'landing.analytics.clarity_id' => 'abc123']);

        $this->get('/')->assertOk()
            ->assertSee('data-cookie-banner', false)
            ->assertSee('data-consent="marketing"', false)
            ->assertSee('data-consent="analytics"', false)
            ->assertSee('data-cookie-preferences', false)
            ->assertSee('"pixel":"1234567890"', false)
            ->assertDontSee('capi', false);
    }

    public function test_api_lists_events_by_id_with_tag_status(): void
    {
        config(['services.integrataller.api_token' => 'api-token', 'landing.analytics.clarity_id' => 'abc123']);
        foreach (['/', '/servicios', '/contacto'] as $path) {
            $this->beacon(['t' => 'pageview', 'p' => $path, 'a' => $this->attribution()]);
        }
        $first = AnalyticsEvent::orderBy('id')->first();

        $this->withToken('api-token')->getJson('/api/v1/landing/analytics-events?limit=2')
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.path', '/')
            ->assertJsonPath('data.0.utm_campaign', 'Lanzamiento octubre')
            ->assertJsonPath('pagination.has_more', true)
            ->assertJsonPath('tags.clarity', true)
            ->assertJsonPath('tags.meta_pixel', false)
            ->assertJsonPath('stats.total', 3)
            ->assertJsonPath('stats.last_24h', 3)
            ->assertJsonMissingPath('data.0.ip');

        $this->withToken('api-token')->getJson('/api/v1/landing/analytics-events?after_id='.($first->id + 1))
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.path', '/contacto')
            ->assertJsonPath('pagination.has_more', false);

        $this->flushHeaders()->getJson('/api/v1/landing/analytics-events')->assertUnauthorized();
    }
}
