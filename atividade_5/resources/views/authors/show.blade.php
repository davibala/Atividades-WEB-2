@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Detalhes do autor</h1>

    <div class="card">
        <div class="card-header">
            Autor: {{ $author->name }}
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $author->id }}</p>
            <p><strong>Nome:</strong> {{ $author->name }}</p>
            <p><strong>Data de aniversário:</strong> {{ $author->birth_date }}</p>
            <p><strong>Adicionado em:</strong> {{ $author->created_at }}</p>   
            <p><strong>Atualizado em:</strong> {{ $author->updated_at }}</p>   
        </div>
    </div>

    <a href="{{ route('authors.index') }}" class="btn btn-secondary mt-3">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
</div>
@endsection