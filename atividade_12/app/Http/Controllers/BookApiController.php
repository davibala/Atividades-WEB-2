<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookApiController extends Controller
{
    public function index()
    {
        return Book::all();
    }
    
    public function store(Request $request)
    {
        $book = Book::create($request->all());
        return response()->json($book, 201);
    }

    public function show(string $id)
    {
        $book = Book::find($id);
        return response()->json($book);
    }

    public function update(Request $request, string $id)
    {
        $book = Book::find($id);
        $book->update($request->all());
        return response()->json($book);
    }

    public function destroy(string $id)
    {
        $book = Book::find($id);
        $book->delete();
        return response()->json(null, 204);
    }
}
