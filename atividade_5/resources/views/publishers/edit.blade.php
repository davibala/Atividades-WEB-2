@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Editar Editor(a)</h1>

    <form action="{{ route('publishers.update', $publisher) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $publisher->name) }}" required>
            <label for="address" class="form-label">Data de aniversário</label>
            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $publisher->address) }}">
            @error('name', 'address')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-save"></i> Atualizar
        </button>
        <a href="{{ route('publishers.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    </form>
</div>
@endsection