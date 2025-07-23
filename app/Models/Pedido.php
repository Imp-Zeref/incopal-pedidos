<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'observacao',
        'dt_previsao',
        'urgente',
        'fk_usuario',
        'fk_cliente',
        'fk_status_pedido',
        'fk_tipo_pedido',
    ];

    protected $casts = [
        'dt_previsao' => 'date',
        'urgente' => 'boolean',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'fk_usuario');
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'fk_cliente');
    }

    public function statusPedido(): BelongsTo
    {
        return $this->belongsTo(StatusPedido::class, 'fk_status_pedido');
    }

    public function tipoPedido(): BelongsTo
    {
        return $this->belongsTo(TipoPedido::class, 'fk_tipo_pedido');
    }

    public function produtos(): BelongsToMany
    {
        return $this->belongsToMany(Produto::class, 'lista_produtos', 'fk_pedido', 'fk_produto');
    }
}