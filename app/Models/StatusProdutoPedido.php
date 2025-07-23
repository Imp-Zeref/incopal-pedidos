<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StatusProdutoPedido extends Model
{
    use HasFactory;
    protected $table = 'status_produto_pedidos';
    protected $fillable = ['nome', 'descricao'];

    public function listaProdutos(): HasMany
    {
        return $this->hasMany(ListaProduto::class, 'fk_status_produto');
    }
}