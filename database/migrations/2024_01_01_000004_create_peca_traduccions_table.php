<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peca_traduccions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peca_id')->constrained('peces')->cascadeOnDelete();
            $table->string('idioma', 5); // ca, es, en, fr
            $table->string('titol');
            $table->string('subtitol')->nullable(); // artista, autor, etc.
            $table->string('periode')->nullable();
            $table->text('descripcio')->nullable();
            $table->string('audio_url')->nullable(); // MP3
            $table->string('audio_descripcio_url')->nullable(); // MP3 audiodescripció
            $table->text('text_audiodescripcio')->nullable();
            $table->timestamps();

            $table->unique(['peca_id', 'idioma']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peca_traduccions');
    }
};
