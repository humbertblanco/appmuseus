<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exposicions', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('imatge_portada')->nullable();
            $table->integer('ordre')->default(0);
            $table->boolean('activa')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exposicions');
    }
};
