<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BlocoNotas extends Model
{
    use HasFactory;

    protected $table = 'bloco_notas';

    protected $fillable = [
        'user_id',
        'titulo',
        'nome_cliente',
        'anotacoes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function produtos(): BelongsToMany
    {
        return $this->belongsToMany(Produto::class, 'bloco_notas_produtos')
                    ->withPivot('quantidade')
                    ->withTimestamps();
    }
}