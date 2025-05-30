<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    // Exibe uma lista de categorias
    public function index()
    {
        $authors = Author::all();
        return view('authors.index', compact('authors'));
    }

    // Mostra o formulário para criar uma nova categoria
    public function create()
    {
        return view('authors.create');
    }

    // Armazena uma nova categoria no banco de dados
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:authors|max:255',
            'birth-date' => 'date|max:255',
        ]);

        Author::create($request->all());

        return redirect()->route('authors.index')->with('success', 'Autor(a) adicionado com sucesso.');
    }

    // Exibe uma categoria específica
    public function show(Author $author)
    {
        return view('authors.show', compact('author'));
    }

    // Mostra o formulário para editar uma categoria existente
    public function edit(Author $author)
    {
        return view('authors.edit', compact('author'));
    }

    // Atualiza uma categoria no banco de dados
    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|string|unique:authors|max:255',
        ]);

        $author->update($request->all());

        return redirect()->route('authors.index')->with('success', 'Autor(a) atualizado com sucesso.');
    }

    // Remove uma categoria do banco de dados
    public function destroy(Author $author)
    {
        $author->delete();

        return redirect()->route('authors.index')->with('success', 'Autor(a) excluído com sucesso.');
    }

}
