<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique();
            $table->string('password');
            $table->boolean('bloqueado')->default(false);
            $table->json('hidden_columns')->nullable();
            $table->foreignId('fk_tipo_usuario')->constrained('tipo_usuarios');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};