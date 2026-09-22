<?php

namespace Tests\Feature;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

    public function test_contact_form_stores_a_message(): void
    {
        $response = $this->post('/contacto', [
            'name' => 'Juan Pérez',
            'taller' => 'Taller Central',
            'phone' => '3364006452',
            'message' => 'Quiero cotizar el sistema.',
        ]);

        $response->assertRedirect(route('contacto'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('contacts', [
            'name' => 'Juan Pérez',
            'taller' => 'Taller Central',
        ]);

        $this->assertSame(1, Contact::count());
    }

    public function test_contact_form_requires_all_fields(): void
    {
        $response = $this->post('/contacto', []);

        $response->assertSessionHasErrors(['name', 'taller', 'phone', 'message']);
        $this->assertSame(0, Contact::count());
    }
}
