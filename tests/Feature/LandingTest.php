<?php

namespace Tests\Feature;

use App\Mail\ConfirmNewsletterSubscription;
use App\Mail\DemoRequestNotification;
use App\Models\Contact;
use App\Models\NewsletterSubscriber;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
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

    public function test_home_shows_audience_offer_and_the_self_service_signup(): void
    {
        config(['landing.saas_url' => 'https://app.integrataller.com']);

        $html = $this->get('/')
            ->assertOk()
            ->assertSee('Para talleres con varias sucursales o equipos de 4 o más')
            ->assertSee('1 mes gratis + 50% en la beta')
            ->assertSee('data-demo-dialog', false)
            ->assertDontSee('cotizador')
            ->getContent();

        // Portada: la demo sigue siendo el principal; el alta es el segundo botón y "Ver cómo funciona" pasa a enlace.
        $this->assertStringContainsString('class="boton boton-claro" data-cta="demo">Pedí tu demo</a>', $html);
        $this->assertStringContainsString('href="https://app.integrataller.com/auth/google/redirect" class="boton boton-borde-claro" data-cta="registro" data-registro>Probá 1 mes gratis</a>', $html);
        $this->assertStringContainsString('>Ver cómo funciona</a>', $html);
        $this->assertStringNotContainsString('class="boton boton-borde-claro">Ver cómo funciona', $html);
        // Clientes actuales: "Ingresar" en el encabezado y en el menú del celular.
        $this->assertSame(2, substr_count($html, 'href="https://app.integrataller.com/login"'));
        // Diálogo de demo con la alternativa del alta.
        $this->assertStringContainsString('¿Preferís empezar solo?', $html);
    }

    public function test_closing_block_on_inner_pages_offers_both_buttons(): void
    {
        $this->get('/servicios')->assertOk()
            ->assertSee('data-cta="registro" data-registro>Probá 1 mes gratis</a>', false)
            ->assertSee('data-cta="demo">Pedí tu demo</a>', false);
    }

    public function test_whatsapp_links_open_the_conversation_with_the_demo_message(): void
    {
        $url = 'https://wa.me/5493364006452?text='.rawurlencode('Hola, quiero ver una demo de IntegraTaller para mi taller');
        config(['landing.whatsapp' => '5493364006452', 'landing.whatsapp_message' => 'Hola, quiero ver una demo de IntegraTaller para mi taller']);

        $this->get('/')->assertSee($url, false);
        $this->get('/contacto')->assertSee($url, false)->assertDontSee('data-demo-dialog', false);
    }

    public function test_short_demo_request_stores_a_contact_and_notifies_the_team(): void
    {
        Mail::fake();
        config(['landing.demo_notification_email' => 'ventas@example.test']);

        $response = $this->post('/contacto', [
            'name' => 'Juan Pérez',
            'phone' => '336 400-6452',
            'branches' => '4+',
        ]);

        $response->assertRedirect(route('demo.thank-you'));

        $this->assertDatabaseHas('contacts', [
            'name' => 'Juan Pérez',
            'taller' => null,
            'email' => null,
            'branches' => '4+',
            'message' => 'Sucursales: 4 o más',
            'source' => 'demo-form',
        ]);

        $this->assertSame(0, NewsletterSubscriber::count());
        Mail::assertSent(DemoRequestNotification::class, fn (DemoRequestNotification $mail) => str_contains($mail->render(), '4 o más'));
    }

    public function test_demo_request_keeps_optional_details_after_the_branches(): void
    {
        $this->post('/contacto', [
            'name' => 'Juan Pérez',
            'taller' => 'Taller Central',
            'phone' => '3364006452',
            'branches' => '2',
            'email' => 'JUAN@example.test',
            'message' => 'Quiero organizar las órdenes.',
        ])->assertRedirect(route('demo.thank-you'));

        $this->assertDatabaseHas('contacts', [
            'taller' => 'Taller Central',
            'email' => 'juan@example.test',
            'message' => "Sucursales: 2\n\nQuiero organizar las órdenes.",
        ]);
    }

    public function test_demo_form_requires_name_whatsapp_and_branches(): void
    {
        $this->post('/contacto', [])
            ->assertSessionHasErrors(['name', 'phone', 'branches'])
            ->assertSessionDoesntHaveErrors(['taller', 'email']);

        $this->post('/contacto', ['name' => 'Ana', 'phone' => '1234-567', 'branches' => '9'])
            ->assertSessionHasErrors(['phone', 'branches']);

        $this->assertSame(0, Contact::count());
    }

    public function test_dialog_submission_gets_json_with_the_thank_you_page(): void
    {
        $this->postJson('/contacto', ['name' => 'Ana', 'phone' => '11 3344-5566', 'branches' => '1'])
            ->assertOk()
            ->assertExactJson(['redirect' => route('demo.thank-you')])
            ->assertSessionHas('conversion', fn (array $conversion) => $conversion['meta'] === 'Lead');

        $this->postJson('/contacto', ['name' => 'Ana'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['phone' => 'Escribí tu WhatsApp.', 'branches']);

        $this->assertSame(1, Contact::count());
    }

    public function test_demo_form_skips_csrf_but_other_forms_keep_it(): void
    {
        // Laravel no valida CSRF en los tests; esta copia del middleware sí lo hace.
        $csrf = new class($this->app, $this->app['encrypter']) extends ValidateCsrfToken
        {
            protected function runningUnitTests()
            {
                return false;
            }
        };
        $request = fn (string $uri) => tap(Request::create($uri, 'POST', ['_token' => 'token-viejo']))
            ->setLaravelSession(tap($this->app['session.store'])->put('_token', 'token-de-la-sesion'));

        // El navegador de Facebook/Instagram puede enviar un token que ya no coincide con la sesión.
        $this->assertSame('ok', $csrf->handle($request('/contacto'), fn () => response('ok'))->getContent());

        $this->expectException(TokenMismatchException::class);
        $csrf->handle($request('/newsletter/suscribir'), fn () => response('ok'));
    }

    public function test_newsletter_opt_in_without_email_is_ignored(): void
    {
        Mail::fake();

        $this->post('/contacto', ['name' => 'Ana', 'phone' => '1133445566', 'branches' => '1', 'marketing_opt_in' => '1'])
            ->assertRedirect(route('demo.thank-you'));

        $this->assertDatabaseHas('contacts', ['marketing_opt_in_requested' => false]);
        $this->assertSame(0, NewsletterSubscriber::count());
        Mail::assertNothingSent();
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
            'branches' => '1',
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
