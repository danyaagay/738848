<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\BookRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    private $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function genre($bookId, $genreId)
    {
        return $this->bookRepository->attach($bookId, $genreId);
    }

    public function genreDestroy($bookId, $genreId)
    {
        return $this->bookRepository->detach($bookId, $genreId);;
    }

    public function index(Request $request)
    {
        return $this->bookRepository->all($request);
    }

    public function show($id)
    {
        return $this->bookRepository->one($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'author' => 'required|string',
            'size' => 'required|integer'
        ]);
        $book = Book::create($validated);
        return $book;
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $validated = $request->validate([
            'name' => 'string',
            'author' => 'string',
            'size' => 'integer'
        ]);
        $book->update($validated);
        return $book;
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
    }
}
