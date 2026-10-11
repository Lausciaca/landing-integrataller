<?php

namespace Tests\Feature;

use App\Mail\ConfirmNewsletterSubscription;
use App\Mail\DemoRequestNotification;
use App\Models\Contact;
use App\Models\NewsletterSubscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class LandingTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_load_successfully(): void
    {
        $routes = [
            '/',
            '/servicios',
            '/tutoriales',
            '/contacto',
            '/demo/solicitada',
            '/newsletter/confirmacion-enviada',
            '/terminos',
            '/politica-de-privacidad',
            '/caracteristicas',
            '/talleres',
        ];

        foreach ($routes as $route) {
            $this->get($route)->assertStatus(200);
        }
    }

    public function test_programmatic_feature_and_city_pages_load(): void
    {
        $this->get('/caracteristicas/control-de-turnos')->assertStatus(200)->assertSee('Control de turnos');
        $this->get('/talleres-en-rosario')->assertStatus(200)->assertSee('Rosario');
    }

    public function test_unknown_programmatic_slug_returns_404(): void
    {
        $this->get('/caracteristicas/no-existe')->assertStatus(404);
        $this->get('/talleres-en-no-existe')->assertStatus(404);
    }

    public function test_sitemap_is_xml_and_includes_programmatic_urls(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml');
        $response->assertSee('/caracteristicas/control-de-turnos', false);
        $response->assertSee('/talleres-en-rosario', false);
    }

    public function test_home_exposes_canonical_and_schema(): void
    {
        $response = $this->get('/');

        $response->assertSee('rel="canonical"', false);
        $response->assertSee('SoftwareApplication', false);
        $response->assertSee('FAQPage', false);
    }

    public function test_demo_request_stores_a_contact_and_notifies_the_team(): void
    {
        Mail::fake();
        config(['landing.demo_notification_email' => 'ventas@example.test']);

        $response = $this->post('/contacto', [
            'name' => 'Juan Pérez',
            'taller' => 'Taller Central',
            'phone' => '3364006452',
            'email' => 'JUAN@example.test',
            'message' => 'Quiero organizar las órdenes.',
        ]);

        $response->assertRedirect(route('demo.thank-you'));

        $this->assertDatabaseHas('contacts', [
            'name' => 'Juan Pérez',
            'taller' => 'Taller Central',
            'email' => 'juan@example.test',
            'source' => 'demo-form',
        ]);

        $this->assertSame(1, Contact::count());
        $this->assertSame(0, NewsletterSubscriber::count());
        Mail::assertSent(DemoRequestNotification::class);
    }

    public function test_demo_form_requires_contact_details_and_email(): void
    {
        $response = $this->post('/contacto', []);

        $response->assertSessionHasErrors(['name', 'taller', 'phone', 'email']);
        $this->assertSame(0, Contact::count());
    }

    public function test_marketing_opt_in_is_separate_and_requires_email_confirmation(): void
    {
        Mail::fake();
        config([
            'landing.demo_notification_email' => null,
        ]);

        $this->post('/contacto', [
            'name' => 'Ana',
            'taller' => 'Taller Norte',
            'phone' => '1133445566',
            'email' => 'ana@example.test',
            'marketing_opt_in' => '1',
        ])->assertRedirect(route('demo.thank-you'))
            ->assertSessionHas('newsletter_result', 'confirmation_sent');

        $subscriber = NewsletterSubscriber::where('email', 'ana@example.test')->firstOrFail();
        $this->assertSame('pending', $subscriber->status);
        $this->assertDatabaseHas('contacts', [
            'email' => 'ana@example.test',
            'marketing_opt_in_requested' => true,
        ]);

        Mail::assertSent(ConfirmNewsletterSubscription::class, function (ConfirmNewsletterSubscription $mail) use (&$token) {
            $token = basename(parse_url($mail->confirmationUrl, PHP_URL_PATH));

            return $token !== '';
        });

        $this->get(route('newsletter.confirm.show', ['token' => $token]))
            ->assertOk()
            ->assertSee('Confirmar suscripción');
        $this->assertSame('pending', $subscriber->fresh()->status);

        $this->post(route('newsletter.confirm'), ['confirmation_token' => $token])->assertOk();
        $this->assertSame('active', $subscriber->fresh()->status);
        $this->assertNotNull($subscriber->fresh()->confirmed_at);

    }

    public function test_visitor_can_subscribe_without_requesting_a_demo(): void
    {
        Mail::fake();

        $this->post(route('newsletter.store'), [
            'subscription_email' => 'interesado@example.test',
            'subscription_source' => 'home',
        ])->assertRedirect(route('newsletter.pending'))
            ->assertSessionHas('newsletter_result', 'confirmation_sent');

        $this->assertSame(0, Contact::count());
        $this->assertDatabaseHas('newsletter_subscribers', [
            'email' => 'interesado@example.test',
            'status' => 'pending',
            'source' => 'home',
        ]);
        Mail::assertSent(ConfirmNewsletterSubscription::class);
    }

    public function test_unsubscribed_email_is_removed_from_active_marketing_list(): void
    {
        $subscriber = NewsletterSubscriber::create([
            'email' => 'baja@example.test',
            'status' => 'active',
            'unsubscribe_token_hash' => hash('sha256', str_repeat('a', 64)),
            'source' => 'guias',
            'consent_version' => '2026-10-v1',
            'consented_at' => now(),
            'confirmed_at' => now(),
        ]);

        $this->get(route('newsletter.unsubscribe.show', ['token' => str_repeat('a', 64)]))
            ->assertOk()
            ->assertSee('Dar de baja la suscripción');

        $this->post(route('newsletter.unsubscribe'), ['unsubscribe_token' => str_repeat('a', 64)])
            ->assertOk()
            ->assertSee('Ya no vas a recibir emails');

        $this->assertSame('unsubscribed', $subscriber->fresh()->status);
        $this->assertNotNull($subscriber->fresh()->unsubscribed_at);
    }
}
