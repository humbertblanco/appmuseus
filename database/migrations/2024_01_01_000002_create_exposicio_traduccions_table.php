<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exposicio_traduccions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exposicio_id')->constrained('exposicions')->cascadeOnDelete();
            $table->string('idioma', 5); // ca, es, en, fr
            $table->string('titol');
            $table->text('descripcio')->nullable();
            $table->string('adreca')->nullable();
            $table->string('telefon')->nullable();
            $table->string('email')->nullable();
            $table->string('web_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->timestamps();

            $table->unique(['exposicio_id', 'idioma']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exposicio_traduccions');
    }
};
