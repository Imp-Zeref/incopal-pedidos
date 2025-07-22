<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoUsuario extends Model
{
    use HasFactory;

    protected $table = 'tipo_usuarios';

    protected $fillable = [
        'nome',
        'descricao',
    ];

    public function usuarios(): HasMany
    {
        return $this->hasMany(User::class, 'fk_tipo_usuario');
    }
}