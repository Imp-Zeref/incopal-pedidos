<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $listClientes = [
            'Carlos',
            'João',
            'Bruno',
            'Lucas',
            'Mateus',
            'Gabriel',
            'Pedro',
            'Rafael',
            'Daniel',
            'Felipe',
            'André',
            'Rodrigo',
            'Eduardo',
            'Thiago',
            'Diego',
            'Vinícius',
            'Leonardo',
            'Gustavo',
            'Marcos',
            'Leandro',
            'Henrique',
            'Fernando',
            'Samuel',
            'Caio',
            'Ricardo',
            'Alexandre',
            'Fábio',
            'Igor',
            'Murilo',
            'Brayan',
            'Júlio',
            'Roberto',
            'Vitor',
            'Antônio',
            'Alan',
            'Douglas',
            'Nathan',
            'Luan',
            'César',
            'Márcio',
            'Jefferson',
            'Otávio',
            'Hugo',
            'Danilo',
            'Wesley',
            'Jorge',
            'Renan',
            'Ivan',
            'Luciano',
            'Ruan'
        ];

        foreach ($listClientes as $cliente) {
            Cliente::create([
                'nome' => $cliente,
            ]);
        }
    }
}
