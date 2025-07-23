<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = \App\Models\User::paginate(10); // Paginação para 10 usuários por página
        return view('users.index', compact('users'));
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\App\Models\User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, \App\Models\User $user)
    {
        
        $this->authorize('update', $user);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role' => auth()->user()->isAdmin() ? 'required|in:admin,bibliotecario,cliente' : 'nullable'
        ]);

        $user->update($validated);
        
        \Log::debug('Dados após atualização', ['user' => $user->fresh()->toArray()]);
        
        return redirect()->route('users.index')->with('success', 'Usuário atualizado');
    }
}
