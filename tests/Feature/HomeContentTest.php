<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class HomeContentTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['landing.saas_url' => 'https://app.integrataller.test', 'landing.pricing_fallback' => [], 'landing.video_url' => null]);
        Http::fake(['https://app.integrataller.test/*' => Http::response(null, 503)]);
    }

    public function test_preguntas_nuevas_desplegables_y_en_el_json_ld(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        foreach ([
            '¿Tengo que firmar un contrato o hay permanencia?',
            'Tengo todo en Excel o en otro sistema, ¿cómo paso mis datos?',
            '¿Emite factura electrónica de ARCA?',
            '¿Qué pasa con mis datos? ¿Puedo exportarlos?',
            '¿Qué pasa si se corta internet?',
            '¿Cómo funciona el mes gratis?',
        ] as $pregunta) {
            $this->assertSame(2, substr_count($html, $pregunta), "Falta en la página o en el FAQPage: {$pregunta}");
        }
        $this->assertGreaterThan(8, substr_count($html, '<details data-revelar class="pregunta'));
        $this->assertStringContainsString('empezás al instante, sin tarjeta. Tenés 30 días', $html);
    }

    public function test_beneficios_en_plata_y_reversion_de_riesgo(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        $this->assertStringContainsString('Ninguna orden se te pasa sin cobrar.', $html);
        $this->assertStringContainsString('Presupuestos por WhatsApp', $html);
        $this->assertStringContainsString('Con recuperar un trabajo sin cobrar por mes, el sistema se paga solo.', $html);
        // Portada y cierre (precios no se muestra sin datos del SaaS).
        $this->assertSame(2, substr_count($html, '1 mes gratis, sin tarjeta. Sin permanencia. Cancelás cuando quieras.'));
    }

    public function test_capturas_reales_con_dimensiones_y_carga_diferida_fuera_de_la_portada(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        $this->assertStringContainsString('img/producto/panel-sucursales-celular.webp', $html);
        foreach (['orden-de-trabajo', 'historial-patente', 'caja-del-dia', 'presupuesto-whatsapp'] as $captura) {
            $this->assertMatchesRegularExpression('~img/producto/'.$captura.'\.webp" alt="[^"]+" width="\d+" height="\d+" loading="lazy"~', $html);
            $this->assertFileExists(public_path("img/producto/{$captura}.webp"));
            $this->assertLessThan(200 * 1024, filesize(public_path("img/producto/{$captura}.webp")));
        }
        $this->assertStringNotContainsString('<x-nodos', $html);
    }

    public function test_el_menu_ya_no_lleva_a_clientes(): void
    {
        $this->get('/')->assertOk()->assertDontSee('#clientes"', false);
    }

    public function test_el_video_solo_aparece_si_esta_configurado(): void
    {
        $this->get('/')->assertDontSee('data-video-youtube', false);

        config(['landing.video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ']);
        $this->get('/')->assertSee('data-video-youtube="dQw4w9WgXcQ"', false)->assertSee('loading="lazy"', false);

        config(['landing.video_url' => 'https://integrataller.com/video/recorrido.mp4']);
        $this->get('/')->assertSee('preload="none"', false)->assertSee('poster=', false)->assertSee('recorrido.mp4', false);
    }

    public function test_testimonio_muestra_los_datos_nuevos_cuando_estan_cargados(): void
    {
        $this->get('/')->assertSee('Taller Sciaca')->assertSee('Servicios para automotores');

        config(['landing.testimonials.0.name' => 'Nombre Apellido', 'landing.testimonials.0.role' => 'Dueño', 'landing.testimonials.0.size' => '2 sucursales']);
        $this->get('/')->assertSee('Nombre Apellido')->assertSee('Dueño, Taller Sciaca')->assertSee('2 sucursales');
    }
}
