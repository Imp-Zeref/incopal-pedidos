<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListaProduto extends Pivot
{
    use HasFactory;

    protected $table = 'lista_produtos';

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class, 'fk_pedido');
    }

    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class, 'fk_produto');
    }

    public function fornecedor(): BelongsTo
    {
        return $this->belongsTo(Fornecedor::class, 'fk_fornecedor');
    }

    public function statusProduto(): BelongsTo
    {
        return $this->belongsTo(StatusProdutoPedido::class, 'fk_status_produto');
    }
}