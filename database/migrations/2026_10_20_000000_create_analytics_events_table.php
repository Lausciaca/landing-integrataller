<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // First-party, cookie-free analytics. No IP addresses are stored:
        // visitor_hash rotates daily and cannot identify a person.
        Schema::create('analytics_events', function (Blueprint $table) {
            $table->id();
            $table->timestamp('occurred_at');
            $table->string('session_id', 64);
            $table->char('visitor_hash', 16);
            $table->string('type', 30);
            $table->string('path', 255);
            $table->string('landing_page', 255)->nullable();
            $table->string('referrer_host', 150)->nullable();
            $table->string('utm_source', 150)->nullable();
            $table->string('utm_medium', 150)->nullable();
            $table->string('utm_campaign', 150)->nullable();
            $table->string('utm_content', 150)->nullable();
            $table->string('utm_term', 150)->nullable();
            $table->string('click_id', 10)->nullable();
            $table->string('device', 10);
            $table->string('browser', 30)->nullable();
            $table->string('os', 20)->nullable();
            $table->string('label', 150)->nullable();
            $table->unsignedInteger('value')->nullable();

            $table->index('occurred_at');
            $table->index(['type', 'occurred_at']);
            $table->index(['visitor_hash', 'occurred_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analytics_events');
    }
};
