<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('estadistiques', function (Blueprint $table) {
            $table->string('tipus', 20)->default('visita')->after('idioma');
            // tipus: 'qr_scan' per escanejat QR, 'visita' per visita normal
            $table->index('tipus');
        });
    }

    public function down(): void
    {
        Schema::table('estadistiques', function (Blueprint $table) {
            $table->dropIndex(['tipus']);
            $table->dropColumn('tipus');
        });
    }
};
