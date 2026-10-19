<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const COLUMNS = [
        'session_id', 'landing_page', 'referrer_host', 'utm_source', 'utm_medium',
        'utm_campaign', 'utm_content', 'utm_term', 'click_id', 'meta_event_id',
    ];

    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('session_id', 64)->nullable();
            $table->string('landing_page', 255)->nullable();
            $table->string('referrer_host', 150)->nullable();
            $table->string('utm_source', 150)->nullable();
            $table->string('utm_medium', 150)->nullable();
            $table->string('utm_campaign', 150)->nullable();
            $table->string('utm_content', 150)->nullable();
            $table->string('utm_term', 150)->nullable();
            $table->string('click_id', 10)->nullable();
            $table->string('meta_event_id', 64)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn(self::COLUMNS);
        });
    }
};
