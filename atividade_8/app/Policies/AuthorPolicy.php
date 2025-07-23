<?php

namespace App\Policies;

use App\Models\Author;
use App\Models\User;

class AuthorPolicy
{
    public function before(User $user, string $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Author $author): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->role === 'bibliotecario';
    }

    public function update(User $user, Author $author): bool
    {
        return $user->role === 'bibliotecario';
    }

    public function delete(User $user, Author $author): bool
    {
        return $user->isAdmin(); 
    }
}
