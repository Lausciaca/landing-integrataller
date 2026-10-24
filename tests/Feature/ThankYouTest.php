<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ThankYouTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
        $this->withoutDefer();
        config([
            'landing.whatsapp' => '5493364006452',
            'landing.whatsapp_message' => 'Hola, quiero ver una demo de IntegraTaller para mi taller',
            'landing.demo_notification_email' => null,
            'landing.booking_url' => null,
            'landing.saas_url' => 'https://app.integrataller.test',
            'services.integrataller.webhook_url' => null,
            'services.telegram.bot_token' => null,
            'services.telegram.chat_id' => null,
        ]);
        Http::fake(['https://app.integrataller.test/*' => Http::response(null, 503)]);
    }

    private function pedirDemo(array $datos = []): void
    {
        $this->post('/contacto', $datos + ['name' => 'Juan Pérez', 'phone' => '0336 15 400-6452', 'branches' => '2'])
            ->assertRedirect(route('demo.thank-you'));
    }

    private function wa(string $texto): string
    {
        return e('https://wa.me/5493364006452?text='.rawurlencode($texto));
    }

    public function test_gracias_arma_el_whatsapp_con_el_nombre_y_las_sucursales(): void
    {
        $this->pedirDemo();

        $this->get(route('demo.thank-you'))->assertOk()
            ->assertSee('Abrir WhatsApp y confirmar mi demo')
            ->assertSee($this->wa('Hola, soy Juan Pérez. Acabo de pedir una demo de IntegraTaller. Tengo 2 sucursales.'), false)
            ->assertSee('Te escribimos en menos de 2 horas, de lunes a sábado de 9 a 19.')
            ->assertSee('Mientras tanto, podés probarlo ya: 1 mes gratis.')
            ->assertSee('href="https://app.integrataller.test/auth/google/redirect"', false)
            ->assertDontSee('Elegí el horario de tu demo');
    }

    public function test_el_mensaje_usa_singular_y_4_o_mas(): void
    {
        $this->pedirDemo(['branches' => '1']);
        $this->get(route('demo.thank-you'))->assertSee($this->wa('Hola, soy Juan Pérez. Acabo de pedir una demo de IntegraTaller. Tengo 1 sucursal.'), false);

        $this->pedirDemo(['branches' => '4+']);
        $this->get(route('demo.thank-you'))->assertSee($this->wa('Hola, soy Juan Pérez. Acabo de pedir una demo de IntegraTaller. Tengo 4 o más sucursales.'), false);
    }

    public function test_sin_datos_en_la_sesion_usa_el_mensaje_por_defecto(): void
    {
        $this->get(route('demo.thank-you'))->assertOk()
            ->assertSee($this->wa('Hola, quiero ver una demo de IntegraTaller para mi taller'), false);
    }

    public function test_con_agenda_configurada_muestra_el_boton_en_otra_pestana(): void
    {
        config(['landing.booking_url' => 'https://calendar.app.google/demo-integrataller']);

        $this->get(route('demo.thank-you'))->assertOk()
            ->assertSee('href="https://calendar.app.google/demo-integrataller" target="_blank" rel="noopener noreferrer" class="boton boton-secundario w-full" data-cta="agenda"', false)
            ->assertSee('Elegí el horario de tu demo');
    }

    public function test_telegram_avisa_cada_demo_con_whatsapp_clickeable_y_fuente(): void
    {
        config(['services.telegram.bot_token' => '123:abc', 'services.telegram.chat_id' => '-100200']);
        Http::fake(['https://api.telegram.org/*' => Http::response(['ok' => true])]);

        $this->pedirDemo([
            'attribution' => json_encode(['session_id' => '3f1c2b9a-0d4e-4c55-9a77-111122223333', 'landing_page' => '/', 'utm_source' => 'facebook', 'utm_campaign' => 'Octubre', 'utm_content' => 'Video <taller>']),
        ]);

        Http::assertSent(function (ClientRequest $request) {
            if (! str_starts_with($request->url(), 'https://api.telegram.org/')) {
                return false;
            }
            $text = $request['text'];

            return $request->url() === 'https://api.telegram.org/bot123:abc/sendMessage'
                && $request['chat_id'] === '-100200'
                && $request['parse_mode'] === 'HTML'
                && str_contains($text, 'Nombre: Juan Pérez')
                && str_contains($text, '<a href="https://wa.me/5493364006452">')
                && str_contains($text, 'Sucursales: 2')
                && str_contains($text, 'Fuente: facebook / Octubre / Video &lt;taller&gt;');
        });
    }

    public function test_sin_variables_de_telegram_no_se_envia_nada(): void
    {
        $this->pedirDemo();

        Http::assertNotSent(fn (ClientRequest $request) => str_contains($request->url(), 'api.telegram.org'));
    }

    public function test_un_error_de_telegram_no_rompe_el_formulario(): void
    {
        config(['services.telegram.bot_token' => '123:abc', 'services.telegram.chat_id' => '-100200']);
        Http::fake(['https://api.telegram.org/*' => fn () => throw new ConnectionException('timeout')]);

        $this->pedirDemo();

        $this->assertDatabaseHas('contacts', ['name' => 'Juan Pérez']);
    }
}
