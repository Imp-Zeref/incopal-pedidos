<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StatusPedido extends Model
{
    use HasFactory;
    protected $table = 'status_pedidos';
    protected $fillable = ['nome', 'descricao'];

    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class, 'fk_status_pedido');
    }
}