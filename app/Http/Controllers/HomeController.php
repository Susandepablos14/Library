<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Copy;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $books = Book::with('image', 'copies')->get();
        $availableBooks = Copy::where('status', 'Disponible')->sum('quantity');
        $loanedBooks = Copy::where('status', 'Prestado')->sum('quantity');
        $reservedBooks = Copy::where('status', 'Reservado')->sum('quantity');
        $lostBooks = Copy::where('status', 'Perdido')->sum('quantity');
        return view('home', compact('books', 'availableBooks', 'loanedBooks', 'reservedBooks', 'lostBooks'));
    }

    public function bookDetail($id)
    {
        $book = Book::with('image','copies', 'author.image', 'category','editorial.image')->findOrFail($id);
        return view('book-detail', compact('book'));
    }
}
