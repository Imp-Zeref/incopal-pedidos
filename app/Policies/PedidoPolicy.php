<?php

namespace App\Policies;

use App\Models\Pedido;
use App\Models\User;

class PedidoPolicy
{
    /**
     * Regra que é executada antes de todas as outras.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->tipoUsuario->nome === 'Administrador') {
            return true;
        }
        return null;
    }

    /**
     * Determina se um usuário pode ver um pedido.
     */
    public function view(User $user, Pedido $pedido): bool
    {
        return $user->id === $pedido->fk_usuario;
    }

    /**
     * Determina se um usuário pode atualizar os dados de um pedido.
     */
    public function update(User $user, Pedido $pedido): bool
    {
        if (in_array($pedido->statusPedido->nome, ['Concluído', 'Cancelado'])) {
            return false;
        }
        return $user->id === $pedido->fk_usuario;
    }

    /**
     * Determina se um usuário pode adicionar produtos a um pedido.
     */
    public function addProduct(User $user, Pedido $pedido): bool
    {
        return $this->update($user, $pedido);
    }
    
    /**
     * Determina se um usuário (apenas admin) pode alterar o status de um pedido.
     */
    public function changeStatus(User $user, Pedido $pedido): bool
    {
        if (in_array($pedido->statusPedido->nome, ['Concluído', 'Cancelado'])) {
            return false;
        }
        return true;
    }

    /**
     * Determina se um usuário pode cancelar um pedido.
     */
    public function cancel(User $user, Pedido $pedido): bool
    {
        return $pedido->statusPedido->nome === 'Pendente' && $user->id === $pedido->fk_usuario;
    }
}