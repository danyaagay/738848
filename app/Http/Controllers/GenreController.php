<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;

class GenreController extends Controller
{

    public function index()
    {
        return Genre::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string'
        ]);
        $genre = Genre::create($validated);
        return $genre;
    }

    public function destroy($id)
    {
        $genre = Genre::findOrFail($id);
        $genre->delete();
    }
}
