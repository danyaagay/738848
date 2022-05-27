<?php

namespace App\Repositories;

use App\Models\Book;
use App\Repositories\Interfaces\BookRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class BookRepository implements BookRepositoryInterface
{
    public function all($request)
    {
        $book = Book::query();
        $data = $request->all();

//        $genres = explode(',', $request->genres);

        foreach ($data as $key => $value) {
            if ($key === 'api_token') continue;
            elseif ($key === 'sort') {
                $sorts = explode(',', $request->sort);
                if ($sorts) {
                    foreach ($sorts as $sort) {
                        $book = $book->orderBy($sort);
                    }
                }
            } else {
                $book = $book->where($key, $value);
            }
        }

        $book = Book::find(1);

        $addd = [];
        foreach ($book->genres() as $genre) {
            $addd[] = $genre->pivot->name;
        }

        return $addd;

        //return $book->with('genres')->get();
            
        //return Book::with('genres')->get();

    }

    public function one($id)
    {
        return Book::with('genres')->find($id);
    }

    public function attach($bookId, $genreId)
    {
        $book = Book::whereDoesntHave('genres', function (Builder $query) use ($genreId) {
            $query->where('genre_id', '=', $genreId);
        })->find($bookId);

        if ($book) {
            $book->genres()->attach($genreId,
                ['name' => 'genres.name']);
            return Book::with('genres')->find($bookId);
        } else {
            return response('The book already has this genre');
        }
    }

    public function detach($bookId, $genreId)
    {
        $book = Book::findOrFail($bookId);
        $book->genres()->detach($genreId);
        return Book::with('genres')->find($bookId);
    }
}