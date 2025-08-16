@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                    <h1>Rotas</h1>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Usuários</th>
                                <th>Autores</th>
                                <th>Livros</th>
                                <th>Categorias</th>
                                <th>Editoras</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th><a href="/users">Usuários</a></th>
                                <th><a href="/authors">Autores</a></th>
                                <th><a href="/books">Livros</a></th>
                                <th><a href="/categories">Categorias</a></th>
                                <th><a href="/publishers">Editoras</a></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
