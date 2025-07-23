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
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('nome')->nullable();
            $table->string('descricao')->nullable();
            $table->string('descricao2')->nullable();
            $table->string('descricao3')->nullable();
            $table->string('original')->nullable();
            $table->string('secundario')->nullable();
            $table->string('aplicacao')->nullable();
            $table->string('localizacao')->nullable();
            $table->string('unidadeMedida')->nullable();
            $table->boolean('bloqueado')->nullable();
            $table->string('diversa')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
