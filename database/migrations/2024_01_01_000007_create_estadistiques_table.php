<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estadistiques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peca_id')->nullable()->constrained('peces')->nullOnDelete();
            $table->foreignId('exposicio_id')->nullable()->constrained('exposicions')->nullOnDelete();
            $table->string('idioma', 5)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('ip_hash', 64)->nullable(); // hash per privacitat
            $table->timestamps();

            $table->index('created_at');
            $table->index(['peca_id', 'created_at']);
            $table->index(['exposicio_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estadistiques');
    }
};
