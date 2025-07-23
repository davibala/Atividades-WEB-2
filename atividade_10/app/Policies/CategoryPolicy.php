<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
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

    public function view(User $user, Category $category): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->role === 'bibliotecario';
    }

    public function update(User $user, Category $category): bool
    {
        return $user->role === 'bibliotecario';
    }

    public function delete(User $user, Category $category): bool
    {
        return $user->isAdmin(); 
    }
}