<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peca_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peca_id')->constrained('peces')->cascadeOnDelete();
            $table->string('idioma', 5);
            $table->string('tipus'); // pdf, link, etc.
            $table->string('titol');
            $table->string('url');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peca_materials');
    }
};
