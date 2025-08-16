<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\Borrowing;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request, Book $book)
    {
        $this->authorize('create', Book::class);

        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        
        $existBorrowing = Borrowing::where('book_id', $book['id'])->where('returned_at', null)->exists();
        $user = User::where('id', $request['user_id'])->first();
        $borrowingsOpenCount = $user->books()->where('returned_at', null)->count();

        if($existBorrowing){
            return redirect()->back()->with('error', 'Este livro já foi emprestado.');
        } elseif($borrowingsOpenCount >= 5) {
            return redirect()->back()->with('error', 'Cada usuário poderá ter no máximo 5 livros emprestados.');
        } elseif($user->debit != 0){
            $valor = $user->debit;
            return redirect()->back()->with('error', 'O usuário possui dívidas no valor de R$' . $valor . ' a serem quitadas.');
        }

        Borrowing::create([
            'user_id' => $request->user_id,
            'book_id' => $book->id,
            'borrowed_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Empréstimo registrado com sucesso.');
    }

    public function returnBook(Borrowing $borrowing)
    {
        $this->authorize('update', [User::where('id', $borrowing['user_id'])->first(), Book::class]);

        $datEmprestimo = Carbon::parse($borrowing['borrowed_at']);
        $datAtual = Carbon::parse(now()->addMonth());
        $diffDias  = $datEmprestimo->diffInDays($datAtual);
        $diasPendentes = 0;

        if($diffDias > 15){
            $diasPendentes = $diffDias - 15;
        }

        if($diasPendentes > 0){
            $user = User::where('id', $borrowing['user_id'])->first();
            $addDebito = 0;
            
            while($diasPendentes>0){
                $addDebito = $addDebito + 0.5;
                $diasPendentes--;
            }
            
            $newDebito = $user->debit + $addDebito;
            $user->debit = $newDebito;
            $user->save();
        }

        $borrowing->update([
            'returned_at' => now()->addMonth(),
        ]);

        return redirect()->back()->with('success', 'Devolução registrada com sucesso.');
    }

    public function userBorrowings(User $user)
    {
        $borrowings = $user->books()->withPivot('borrowed_at', 'returned_at')->get();

        return view('users.borrowings', compact('user', 'borrowings'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
