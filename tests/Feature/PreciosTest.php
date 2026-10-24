<?php

namespace Tests\Feature;

use App\Services\PlanesPublicos;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PreciosTest extends TestCase
{
    private const URL = 'https://app.integrataller.test/api/planes-publicos';

    protected function setUp(): void
    {
        parent::setUp();
        config(['landing.saas_url' => 'https://app.integrataller.test', 'landing.pricing_fallback' => []]);
    }

    private function pro(array $extra = []): array
    {
        return $extra + [
            'nombre' => 'Pro', 'precio' => 120000, 'descuento_pct' => 40, 'precio_final' => 72000,
            'ia' => false, 'descripcion' => 'Todo IntegraTaller, sin IA.',
        ];
    }

    private function saasResponde(array $planes, array $extra = []): void
    {
        Http::fake([self::URL => Http::response($extra + ['planes' => $planes, 'moneda' => 'ARS', 'prueba_dias' => 30, 'transferencia_descuento_pct' => 0])]);
    }

    public function test_la_home_muestra_los_precios_del_saas_con_el_descuento_del_plan(): void
    {
        $this->saasResponde([$this->pro()]);

        $html = $this->get('/')->assertOk()->getContent();

        $this->assertStringContainsString('id="precios"', $html);
        $this->assertStringContainsString('1 mes gratis + 40% en la beta', $html);
        $this->assertStringContainsString("$\u{00A0}120.000", $html);
        $this->assertStringContainsString("$\u{00A0}72.000", $html);
        $this->assertStringContainsString('por mes, final', $html);
        // Ahorro de la beta calculado con los precios del plan.
        $this->assertStringContainsString("Ahorrás $\u{00A0}48.000 por mes", $html);
        $this->assertStringContainsString('Empezás sin tarjeta', $html);
        // Precio fijo por plan: sin calculadora ni extras.
        $this->assertStringContainsString('Todas tus sucursales y todo tu equipo, sin costo extra.', $html);
        $this->assertStringNotContainsString('¿Cuántas sucursales?', $html);
        $this->assertStringNotContainsString('extra suma', $html);
        $this->assertStringContainsString('Sin permanencia. Cancelás cuando quieras.', $html);
        $this->assertStringContainsString('data-cta="registro"', $html);
        $this->assertStringContainsString('href="https://app.integrataller.test/auth/google/redirect"', $html);
        // Precios entre "Talleres que confían" y "Cómo empezar".
        $this->assertTrue(strpos($html, 'id="clientes"') < strpos($html, 'id="precios"'));
        $this->assertTrue(strpos($html, 'id="precios"') < strpos($html, 'id="como-empezar"'));
        // Menú, pregunta frecuente y datos estructurados.
        $this->assertMatchesRegularExpression('~href="[^"]*#precios"[^>]*>Precios</a>~', $html);
        $this->assertStringContainsString('El plan Pro sale', $html);
        $this->assertStringContainsString('Es un precio fijo', $html);
        $this->assertStringNotContainsString('En la demo te pasamos el precio', $html);
        $this->assertStringContainsString('"offers":{"@type":"Offer","name":"Plan Pro","price":72000', $html);
        $this->assertStringContainsString('"priceCurrency":"ARS"', $html);
        // Sin Corporation no hay segunda tarjeta.
        $this->assertStringNotContainsString('Plan Corporation', $html);
    }

    public function test_corporation_y_transferencia_se_muestran_si_el_saas_los_informa(): void
    {
        $this->saasResponde(
            [$this->pro(), $this->pro(['nombre' => 'Corporation', 'precio' => 200000, 'precio_final' => 120000, 'ia' => true, 'ia_consultas' => 2000])],
            ['transferencia_descuento_pct' => 10],
        );

        $this->get('/')->assertOk()
            ->assertSee('Plan Corporation')
            ->assertSee('Para redes de sucursales que quieren sumar inteligencia artificial.')
            ->assertSee('2.000 consultas de IA por mes')
            ->assertSee('10% menos pagando por transferencia');
    }

    public function test_sin_saas_ni_respaldo_la_home_carga_sin_precios(): void
    {
        Http::fake([self::URL => Http::response('caído', 500)]);

        $html = $this->get('/')->assertOk()->getContent();

        $this->assertStringNotContainsString('id="precios"', $html);
        $this->assertDoesNotMatchRegularExpression('~>Precios</a>~', $html);
        $this->assertStringNotContainsString('"offers"', $html);
        $this->assertStringContainsString('¿Cuánto cuesta?', $html);
    }

    public function test_sin_saas_usa_el_respaldo_de_la_configuracion(): void
    {
        Http::fake([self::URL => Http::response(null, 503)]);
        config(['landing.pricing_fallback' => ['planes' => [$this->pro(['precio' => 90000, 'precio_final' => 45000, 'descuento_pct' => 50])], 'prueba_dias' => 30]]);

        $this->get('/')->assertOk()->assertSee('id="precios"', false)->assertSee("$\u{00A0}45.000");
    }

    public function test_los_precios_quedan_en_cache_una_hora(): void
    {
        $this->saasResponde([$this->pro()]);

        $this->get('/')->assertOk();
        $this->app->forgetScopedInstances();
        $this->get('/servicios')->assertOk();
        $this->app->forgetScopedInstances();
        $this->get('/')->assertOk();
        Http::assertSentCount(1);

        $this->travel(61)->minutes();
        // En producción cada request arma su instancia; en el test se reutiliza la app.
        $this->app->forgetScopedInstances();
        $this->get('/')->assertOk();
        Http::assertSentCount(2);
    }
}
