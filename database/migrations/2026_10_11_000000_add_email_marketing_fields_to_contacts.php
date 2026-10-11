<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('email')->nullable()->after('phone');
            $table->boolean('marketing_opt_in_requested')->default(false)->after('status');
            $table->string('source')->default('contact-form')->after('marketing_opt_in_requested');
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn(['email', 'marketing_opt_in_requested', 'source']);
        });
    }
};
