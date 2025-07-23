<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Author::class);
        $authors = Author::all();
        return view('authors.index', compact('authors'));
    }

    public function create()
    {
        $this->authorize('create', Author::class);
        return view('authors.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Author::class);

        $validated = $request->validate([
            'name' => 'required|string|unique:authors|max:255',
            'birth_date' => 'nullable|date',
        ]);

        Author::create($validated);

        return redirect()->route('authors.index')->with('success', 'Autor criado com sucesso.');
    }

    public function show(Author $author)
    {
        $this->authorize('view', $author);
        return view('authors.show', compact('author'));
    }

    public function edit(Author $author)
    {
        $this->authorize('update', $author);
        return view('authors.edit', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        $this->authorize('update', $author);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:authors,name,'.$author->id,
            'birth_date' => 'nullable|date',
        ]);

        $author->update($validated);

        return redirect()->route('authors.index')->with('success', 'Autor atualizado com sucesso.');
    }

    public function destroy(Author $author)
    {
        $this->authorize('delete', $author);
        $author->delete();
        return redirect()->route('authors.index')->with('success', 'Autor excluído com sucesso.');
    }
}
