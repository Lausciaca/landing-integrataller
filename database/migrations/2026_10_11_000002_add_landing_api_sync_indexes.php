<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->index(['updated_at', 'id'], 'contacts_landing_sync_idx');
        });

        Schema::table('newsletter_subscribers', function (Blueprint $table) {
            $table->index(['updated_at', 'id'], 'newsletter_landing_sync_idx');
            $table->index(['status', 'updated_at', 'id'], 'newsletter_landing_status_sync_idx');
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropIndex('contacts_landing_sync_idx');
        });

        Schema::table('newsletter_subscribers', function (Blueprint $table) {
            $table->dropIndex('newsletter_landing_sync_idx');
            $table->dropIndex('newsletter_landing_status_sync_idx');
        });
    }
};
