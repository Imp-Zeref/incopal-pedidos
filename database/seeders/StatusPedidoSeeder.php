<?php

namespace Database\Seeders;

use App\Models\StatusPedido;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusPedidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nomes = ['Pendente', 'Encomendado', 'Concluído', 'Entregue', 'Cancelado'];

        foreach ($nomes as $nome) {
            StatusPedido::create(['nome' => $nome]);
        }
    }
}
