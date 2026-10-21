<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // The short demo form only asks for name, WhatsApp and number of branches.
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('taller')->nullable()->change();
            $table->string('branches', 10)->nullable()->after('taller');
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('branches');
        });
    }
};
