<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exposicio_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exposicio_id')->constrained('exposicions')->onDelete('cascade');
            $table->string('idioma', 5);
            $table->string('titol');
            $table->string('descripcio')->nullable();
            $table->string('fitxer'); // Path al PDF
            $table->integer('ordre')->default(0);
            $table->boolean('actiu')->default(true);
            $table->timestamps();

            $table->index(['exposicio_id', 'idioma']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exposicio_documents');
    }
};
