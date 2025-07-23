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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->text('observacao')->nullable();
            $table->date('dt_previsao')->nullable();
            $table->boolean('urgente')->default(false);
            $table->foreignId('fk_usuario')->constrained('usuarios');
            $table->foreignId('fk_cliente')->nullable()->constrained('clientes');
            $table->foreignId('fk_status_pedido')->constrained('status_pedidos');
            $table->foreignId('fk_tipo_pedido')->constrained('tipo_pedidos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
