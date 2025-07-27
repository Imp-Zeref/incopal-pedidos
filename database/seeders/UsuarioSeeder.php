<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {

        User::create([
            'nome' => 'Admin',
            'password' => Hash::make('incopal'),
            'fk_tipo_usuario' => 1,
        ]);


        User::create([
            'nome' => 'Vendedor Luiz',
            'password' => Hash::make('incopal'),
            'fk_tipo_usuario' => 2,
        ]);

        User::create([
            'nome' => 'Comprador Davi',
            'password' => Hash::make('incopal'),
            'fk_tipo_usuario' => 3,
        ]);
    }
}
