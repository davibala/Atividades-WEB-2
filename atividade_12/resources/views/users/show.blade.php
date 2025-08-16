@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <h1 class="my-4">Detalhes do Usuário</h1>

        <div class="card">
            <div class="card-header">
                {{ $user->name }}
            </div>
            <div class="card-body">
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Cargo:</strong> {{ $user->role }}</p>
                @if($user->debit != 0)
                    <p class="text-danger"><strong>Dívidas:</strong> {{ 'R$' . $user->debit }}</p>
                    <form action="{{ route('user.quitDebit', $user) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        @can('update', $user)
                            <button class="btn btn-warning btn-sm">Quitar divida</button>
                        @else
                            <p class="bg-warning rounded-2 ps-1" style="width: 26%;">(fale com um bibliotecário para quitar sua dívida.)</p>
                        @endcan
                    </form>
                @else
                    <p><strong>Dívidas: </strong>R$0</p>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">Histórico de Empréstimos</div>
            <div class="card-body">
                @if($user->books->isEmpty())
                    <p>Este usuário não possui empréstimos registrados.</p>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Livro</th>
                                <th>Data de Empréstimo</th>
                                <th>Data de Devolução</th>
                                @can('update', $user)
                                    <th>Ações</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->books as $book)
                                <tr>
                                    <td>
                                        <a href="{{ route('books.show', $book->id) }}">
                                            {{ $book->title }}
                                        </a>
                                    </td>
                                    <td>{{ $book->pivot->borrowed_at }}</td>
                                    <td>{{ $book->pivot->returned_at ?? 'Em Aberto' }}</td>
                                    @can('update', $user)
                                        <td>
                                            @if(is_null($book->pivot->returned_at))
                                            <form action="{{ route('borrowings.return', $book->pivot->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn btn-warning btn-sm">Devolver</button>
                                            </form>
                                            @endif
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <a href="{{ route('users.index') }}" class="btn btn-secondary mt-3">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    </div>
@endsection