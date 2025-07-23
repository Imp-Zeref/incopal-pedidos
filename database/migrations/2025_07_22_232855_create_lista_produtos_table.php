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
        Schema::create('lista_produtos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fk_pedido')->constrained('pedidos')->cascadeOnDelete();
            $table->foreignId('fk_produto')->constrained('produtos');
            $table->foreignId('fk_fornecedor')->nullable()->constrained('fornecedores');
            $table->foreignId('fk_status_produto')->constrained('status_produto_pedidos');
            $table->text('observacao')->nullable();
            $table->decimal('custo', 10, 2)->nullable();
            $table->date('dt_entrega')->nullable();
            $table->decimal('quantidade', 10, 2)->default(1);
            $table->boolean('produto_novo')->default(false);
            $table->string('original_produto_novo')->nullable();
            $table->string('descricao_produto_novo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lista_produtos');
    }
};
