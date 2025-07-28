<?php

namespace App\Policies;

use App\Models\BlocoNotas;
use App\Models\User;

class BlocoNotasPolicy
{
    public function view(User $user, BlocoNotas $blocoNota): bool
    {
        return $user->id === $blocoNota->user_id;
    }

    public function update(User $user, BlocoNotas $blocoNota): bool
    {
        return $user->id === $blocoNota->user_id;
    }

    public function delete(User $user, BlocoNotas $blocoNota): bool
    {
        return $user->id === $blocoNota->user_id;
    }
}