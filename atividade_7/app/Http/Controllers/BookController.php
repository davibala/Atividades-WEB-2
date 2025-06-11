<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Publisher;
use App\Models\Author;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
class BookController extends Controller
{

    public function createWithId()
    {
        return view('books.create-id');
    }

    public function storeWithId(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        Book::create($request->all());

        return redirect()->route('books.index')->with('success', 'Livro criado com sucesso.');
    }

    // Formulário com input select
    public function createWithSelect()
    {
        $publishers = Publisher::all();
        $authors = Author::all();
        $categories = Category::all();

        return view('books.create-select', compact('publishers', 'authors', 'categories'));
    }

    // Salvar livro com input select
        public function storeWithSelect(Request $request)
        {
            $request->validate([
                'title' => 'required|string|max:255',
                'publisher_id' => 'required|exists:publishers,id',
                'author_id' => 'required|exists:authors,id',
                'category_id' => 'required|exists:categories,id',
                'img_link' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
        
            // Cria o gerenciador de imagem
            $manager = new ImageManager(new Driver());
            
            // Processa a imagem
            $file = $request->file('img_link');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Redimensiona e salva
            $image = $manager->read($file);
            $image->resize(200, 300);
            Storage::disk('public')->put("images/{$filename}", $image->encode());
            
            // Prepara os dados para criação
            $data = $request->all();
            $data['img_link'] = "images/{$filename}";
            
            Book::create($data);
        
            return redirect()->route('books.index')->with('success', 'Livro criado com sucesso.');
        }


    public function index()
    {
        $books = Book::with('author')->paginate(20);

        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book->load(['author', 'publisher', 'category']);

        // Carregar todos os usuários para o formulário de empréstimo
        $users = User::all();

        return view('books.show', compact('book', 'users'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $publishers = Publisher::all();
        $authors = Author::all();
        $categories = Category::all();

        return view('books.edit', compact('book', 'publishers', 'authors', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $book->update($request->all());

        return redirect()->route('books.index')->with('success', 'Livro atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
