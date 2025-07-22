<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoUsuario;

class TipoUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoUsuario::create([
            'nome' => 'Administrador',
            'descricao' => 'Usuario responsavel por gerenciar a aplicação',
        ]);

        TipoUsuario::create([
            'nome' => 'Comprador',
            'descricao' => 'Usuario responsavel por comprar mercadorias.',
        ]);

        TipoUsuario::create([
            'nome' => 'Vendedor',
            'descricao' => 'Usuario responsavel por solicitar mercadorias para o vendedor.',
        ]);
    }
}
