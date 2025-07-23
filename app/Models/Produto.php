<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';

    protected $fillable = [
        'nome',
        'descricao',
        'descricao2',
        'descricao3',
        'original',
        'secundario',
        'localizacao',
        'diversa',
        'unidadeMedida',
        'aplicacao',
    ];

    public function pedidos(): BelongsToMany
    {
        return $this->belongsToMany(Pedido::class, 'lista_produtos', 'fk_produto', 'fk_pedido');
    }
}