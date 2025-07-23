<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePedidoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fk_cliente' => 'nullable|exists:clientes,id',
            'fk_tipo_pedido' => 'required|exists:tipo_pedidos,id',
            'dt_previsao' => 'nullable|date',
            'observacao' => 'nullable|string',
            'urgente' => 'nullable|boolean',
            'produtos' => 'nullable|array',
            'produtos.*.produto_id' => 'required_with:produtos|exists:produtos,id',
            'produtos.*.quantidade' => 'required_with:produtos|numeric|min:0.01',
        ];
    }
}
