@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Editar Usuário</h1>

    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Cargo</label>
                @if(auth()->user()->isAdmin())
                    <select id="role" name="role" class="form-select" {{ auth()->user()->isAdmin() ? '' : 'disabled' }}>
                        @foreach(['admin' => 'Admin', 'bibliotecario' => 'Bibliotecário', 'cliente' => 'Cliente'] as $value => $label)
                            <option value="{{ $value }}" {{ $user->role === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                @else
                    <input type="text" class="form-control" value="{{ 
                        match($user->role) {
                            'admin' => 'Admin',
                            'bibliotecario' => 'Bibliotecário',
                            'cliente' => 'Cliente',
                            default => $user->role
                        }
                    }}" disabled>
                @endif
                </div>

            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection