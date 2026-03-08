<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exposicio_id')->constrained('exposicions')->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->integer('ordre')->default(0);
            $table->boolean('activa')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peces');
    }
};
