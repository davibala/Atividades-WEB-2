@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">Editar Livro</h1>

        <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Título</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                    value="{{ old('title', $book->title) }}" required>
                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="publisher_id" class="form-label">Editora</label>
                <select class="form-select @error('publisher_id') is-invalid @enderror" id="publisher_id"
                    name="publisher_id" required>
                    <option value="" disabled>Selecione uma editora</option>
                    @foreach($publishers as $publisher)
                        <option value="{{ $publisher->id }}" {{ $publisher->id == $book->publisher_id ? 'selected' : '' }}>
                            {{ $publisher->name }}
                        </option>
                    @endforeach
                </select>
                @error('publisher_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="author_id" class="form-label">Autor</label>
                <select class="form-select @error('author_id') is-invalid @enderror" id="author_id" name="author_id"
                    required>
                    <option value="" disabled>Selecione um autor</option>
                    @foreach($authors as $author)
                        <option value="{{ $author->id }}" {{ $author->id == $book->author_id ? 'selected' : '' }}>
                            {{ $author->name }}
                        </option>
                    @endforeach
                </select>
                @error('author_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Categoria</label>
                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id"
                    required>
                    <option value="" disabled>Selecione uma categoria</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $book->category_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <label for="img_link" class="form-label">Imagem do livro:</label>
            <div class="mb-3">
                @if (isset($book->img_link))
                    <img id="preview-img" src="{{ asset('storage/' . $book->img_link) }}" alt="Capa do Livro1" class="img-fluid">
                @else
                    <img id="preview-img" src="{{ asset('storage/' . '/images/no-image.jpg') }}" alt="Capa do Livro2" class="img-fluid">
                @endif
                
                    <input type="file" accept="image/*" class="form-control @error('img_link') is-invalid @enderror"
                    id="img_link" name="img_link" value="{{ old('img_link', $book->img_link) }}">
                    @error('img_link')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-success">Atualizar</button>
            <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection