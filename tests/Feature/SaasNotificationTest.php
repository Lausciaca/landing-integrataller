<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\NewsletterSubscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SaasNotificationTest extends TestCase
{
    use RefreshDatabase;

    private const WEBHOOK = 'https://app.integrataller.test/webhooks/landing';

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
        $this->withoutDefer();
        config([
            'landing.demo_notification_email' => null,
            'services.integrataller.api_token' => 'shared-secret',
            'services.integrataller.webhook_url' => self::WEBHOOK,
        ]);
    }

    private function demo(array $extra = []): array
    {
        return [
            'name' => 'Juan Pérez',
            'taller' => 'Taller Central',
            'branches' => '2',
            'phone' => '3364006452',
            'email' => 'juan@example.test',
            ...$extra,
        ];
    }

    public function test_demo_request_notifies_the_admin_app_without_personal_data(): void
    {
        Http::fake([self::WEBHOOK => Http::response(['queued' => true], 202)]);

        $this->post('/contacto', $this->demo())->assertRedirect(route('demo.thank-you'));

        $contact = Contact::firstOrFail();
        Http::assertSent(fn (ClientRequest $request) => $request->url() === self::WEBHOOK
            && $request->method() === 'POST'
            && $request->hasHeader('Authorization', 'Bearer shared-secret')
            && $request->data() === ['event' => 'demo-request.created', 'id' => $contact->id]);
        Http::assertSentCount(1);
    }

    public function test_newsletter_subscription_notifies_the_admin_app(): void
    {
        Http::fake([self::WEBHOOK => Http::response(['queued' => true], 202)]);

        $this->post(route('newsletter.store'), [
            'subscription_email' => 'interesado@example.test',
            'subscription_source' => 'footer',
        ])->assertRedirect(route('newsletter.pending'));

        $subscriber = NewsletterSubscriber::firstOrFail();
        Http::assertSent(fn (ClientRequest $request) => $request->data() === ['event' => 'newsletter-subscriber.updated', 'id' => $subscriber->id]);
    }

    public function test_nothing_is_sent_when_the_webhook_is_not_configured(): void
    {
        config(['services.integrataller.webhook_url' => null]);
        Http::fake();

        $this->post('/contacto', $this->demo())->assertRedirect(route('demo.thank-you'));

        $this->assertSame(1, Contact::count());
        Http::assertNothingSent();
    }

    public function test_admin_app_failures_never_break_the_form(): void
    {
        Http::fake([self::WEBHOOK => Http::failedConnection()]);

        $this->post('/contacto', $this->demo())->assertRedirect(route('demo.thank-you'));

        Http::fake([self::WEBHOOK => Http::response('error', 500)]);

        $this->post('/contacto', $this->demo(['email' => 'otro@example.test']))->assertRedirect(route('demo.thank-you'));

        $this->assertSame(2, Contact::count());
    }
}
