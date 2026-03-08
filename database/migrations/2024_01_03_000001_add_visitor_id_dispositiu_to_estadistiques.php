<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('estadistiques', function (Blueprint $table) {
            $table->string('visitor_id', 32)->nullable()->after('ip_hash');
            $table->string('dispositiu', 10)->nullable()->after('visitor_id');

            $table->index('visitor_id');
            $table->index('dispositiu');
        });
    }

    public function down(): void
    {
        Schema::table('estadistiques', function (Blueprint $table) {
            $table->dropIndex(['visitor_id']);
            $table->dropIndex(['dispositiu']);
            $table->dropColumn(['visitor_id', 'dispositiu']);
        });
    }
};
