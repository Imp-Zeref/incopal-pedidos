<?php

namespace App\Policies;

use App\Models\Pedido;
use App\Models\User;

class PedidoPolicy
{
    private function isAdmin(User $user): bool
    {
        return $user->tipoUsuario->nome === 'Administrador';
    }

    private function isOwner(User $user, Pedido $pedido): bool
    {
        return $user->id === $pedido->fk_usuario;
    }

    private function isLocked(Pedido $pedido): bool
    {
        return in_array($pedido->statusPedido->nome, ['Concluído', 'Cancelado']);
    }

    public function view(User $user, Pedido $pedido): bool
    {
        return $this->isOwner($user, $pedido) || $this->isAdmin($user);
    }

    public function update(User $user, Pedido $pedido): bool
    {
        if ($this->isLocked($pedido)) {
            return false;
        }
        return $this->isOwner($user, $pedido) || $this->isAdmin($user);
    }

    public function addProduct(User $user, Pedido $pedido): bool
    {
        if ($this->isLocked($pedido)) {
            return false;
        }
        return $this->isOwner($user, $pedido) || $this->isAdmin($user);
    }
    
    public function changeStatus(User $user, Pedido $pedido): bool
    {
        if ($this->isLocked($pedido)) {
            return false;
        }
        return $this->isAdmin($user);
    }

    public function cancel(User $user, Pedido $pedido): bool
    {
        return $this->isOwner($user, $pedido) && $pedido->statusPedido->nome === 'Pendente';
    }
}