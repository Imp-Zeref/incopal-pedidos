<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bloco_notas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('usuarios')->cascadeOnDelete();
            $table->string('titulo')->default('Minha Anotação');
            $table->string('nome_cliente')->nullable();
            $table->text('anotacoes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bloco_notas');
    }
};
