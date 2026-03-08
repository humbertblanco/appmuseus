<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('redireccions', function (Blueprint $table) {
            $table->id();
            $table->string('origen')->unique(); // path antic
            $table->string('desti'); // path nou
            $table->integer('tipus')->default(301); // 301 o 302
            $table->boolean('activa')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('redireccions');
    }
};
