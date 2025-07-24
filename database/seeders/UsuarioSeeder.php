<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\TipoUsuario;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        $tipoAdmin = TipoUsuario::where('nome', 'Administrador')->first();

        if ($tipoAdmin) {
            User::create([
                'nome' => 'Admin',
                'password' => Hash::make('incopal'),
                'fk_tipo_usuario' => $tipoAdmin->id,
            ]);
        }

        User::create([
            'nome' => 'Vendedor Luiz',
            'password' => Hash::make('incopal'),
            'fk_tipo_usuario' => 3,
        ]);
    }
}
