<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\NewsletterSubscriber;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['services.integrataller.api_token' => 'test-landing-token']);
    }

    public function test_landing_api_rejects_missing_and_unconfigured_tokens(): void
    {
        $this->getJson('/api/v1/landing/demo-requests')->assertUnauthorized();

        config(['services.integrataller.api_token' => null]);

        $this->withToken('test-landing-token')
            ->getJson('/api/v1/landing/demo-requests')
            ->assertServiceUnavailable();
    }

    public function test_demo_requests_can_be_read_in_cursor_paginated_batches(): void
    {
        foreach (['Taller Norte', 'Taller Centro', 'Taller Sur'] as $index => $workshop) {
            Contact::create([
                'name' => 'Persona '.$index,
                'taller' => $workshop,
                'phone' => '110000000'.$index,
                'email' => 'persona'.$index.'@example.test',
                'message' => 'Quiero conocer el sistema.',
                'marketing_opt_in_requested' => $index === 0,
                'source' => 'demo-form',
            ]);
        }

        $firstPage = $this->withToken('test-landing-token')
            ->getJson('/api/v1/landing/demo-requests?limit=1')
            ->assertOk()
            ->assertJsonPath('data.0.workshop', 'Taller Norte')
            ->assertJsonPath('data.0.marketing_opt_in_requested', true);

        $firstPagination = $firstPage->json('pagination');
        $this->assertTrue($firstPagination['has_more']);
        $this->assertNotEmpty($firstPagination['next_cursor']);

        $nextQuery = http_build_query([
            'limit' => 1,
            'sync_until' => $firstPagination['sync_until'],
            'cursor' => $firstPagination['next_cursor'],
        ]);

        $secondPage = $this->withToken('test-landing-token')
            ->getJson('/api/v1/landing/demo-requests?'.$nextQuery)
            ->assertOk()
            ->assertJsonPath('data.0.workshop', 'Taller Centro');

        $secondPagination = $secondPage->json('pagination');
        $lastPage = $this->withToken('test-landing-token')
            ->getJson('/api/v1/landing/demo-requests?'.http_build_query([
                'limit' => 1,
                'sync_until' => $secondPagination['sync_until'],
                'cursor' => $secondPagination['next_cursor'],
            ]))
            ->assertOk()
            ->assertJsonPath('data.0.workshop', 'Taller Sur');

        $this->assertFalse($lastPage->json('pagination.has_more'));
    }

    public function test_sync_window_accepts_instants_in_any_timezone(): void
    {
        $this->assertSame('America/Argentina/Buenos_Aires', config('app.timezone'));
        $this->travelTo(CarbonImmutable::parse('2026-10-19 18:55:00', 'America/Argentina/Buenos_Aires'));
        Contact::create([
            'name' => 'Persona', 'taller' => 'Taller', 'branches' => '4+', 'phone' => '1100000000',
            'email' => 'persona@example.test', 'message' => 'Hola', 'source' => 'demo-form',
        ]);

        // 21:54 UTC = 18:54 en Argentina: el registro de las 18:55 queda dentro.
        $this->withToken('test-landing-token')
            ->getJson('/api/v1/landing/demo-requests?'.http_build_query(['updated_since' => '2026-10-19T21:54:00+00:00']))
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.created_at', '2026-10-19T18:55:00-03:00')
            ->assertJsonPath('data.0.branches', '4+');

        $this->travel(10)->minutes();
        $this->withToken('test-landing-token')
            ->getJson('/api/v1/landing/demo-requests?'.http_build_query(['updated_since' => '2026-10-19T21:56:00+00:00']))
            ->assertOk()
            ->assertJsonCount(0, 'data');
    }

    public function test_subscriber_feed_includes_consent_states_without_secrets(): void
    {
        $this->createSubscriber('pending@example.test', 'pending');
        $this->createSubscriber('active@example.test', 'active');
        $this->createSubscriber('unsubscribed@example.test', 'unsubscribed');

        $response = $this->withToken('test-landing-token')
            ->getJson('/api/v1/landing/newsletter-subscribers')
            ->assertOk()
            ->assertJsonCount(3, 'data');

        $this->assertSame(
            ['pending', 'active', 'unsubscribed'],
            collect($response->json('data'))->pluck('status')->all()
        );
        $this->assertStringNotContainsString('confirmation_token_hash', $response->getContent());
        $this->assertStringNotContainsString('unsubscribe_token_hash', $response->getContent());

        $this->withToken('test-landing-token')
            ->getJson('/api/v1/landing/newsletter-subscribers?status=active')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.email', 'active@example.test');
    }

    public function test_admin_can_record_an_idempotent_newsletter_unsubscribe(): void
    {
        $subscriber = $this->createSubscriber('active@example.test', 'active');

        $this->withToken('test-landing-token')
            ->putJson("/api/v1/landing/newsletter-subscribers/{$subscriber->id}/unsubscribe")
            ->assertOk()
            ->assertJsonPath('data.status', 'unsubscribed')
            ->assertJsonPath('changed', true);

        $subscriber->refresh();
        $this->assertNotNull($subscriber->unsubscribed_at);
        $this->assertNull($subscriber->unsubscribe_token_hash);

        $this->withToken('test-landing-token')
            ->putJson("/api/v1/landing/newsletter-subscribers/{$subscriber->id}/unsubscribe")
            ->assertOk()
            ->assertJsonPath('changed', false);
    }

    private function createSubscriber(string $email, string $status): NewsletterSubscriber
    {
        return NewsletterSubscriber::create([
            'email' => $email,
            'status' => $status,
            'confirmation_token_hash' => $status === 'pending' ? hash('sha256', 'confirmation') : null,
            'unsubscribe_token_hash' => $status === 'active' ? hash('sha256', 'unsubscribe') : null,
            'source' => 'home',
            'consent_version' => '2026-10-v1',
            'consented_at' => now(),
            'confirmed_at' => $status === 'active' ? now() : null,
            'unsubscribed_at' => $status === 'unsubscribed' ? now() : null,
        ]);
    }
}
