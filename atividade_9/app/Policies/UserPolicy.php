<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
        
        if (request()->has('role')) {
            request()->request->remove('role');
        }
    }
    
    public function update(User $currentUser, User $targetUser): bool
    {
        return $currentUser->role === 'bibliotecario' && 
               $targetUser->role === 'cliente' &&
               !request()->has('role');
    }
}