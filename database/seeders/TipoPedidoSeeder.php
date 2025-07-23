<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoPedido;

class TipoPedidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoPedido::create([
            'nome' => 'Estoque',
            'descricao' => 'Pedido para reposição de estoque da loja.'
        ]);

        TipoPedido::create([
            'nome' => 'Cliente',
            'descricao' => 'Pedido de um item específico para um cliente.'
        ]);

        TipoPedido::create([
            'nome' => 'Pessoal',
            'descricao' => 'Pedido para uso pessoal ou interno da loja.'
        ]);

        TipoPedido::create([
            'nome' => 'Orcamento',
            'descricao' => 'Apenas uma cotação de preços, não um pedido de compra firme.'
        ]);
    }
}
