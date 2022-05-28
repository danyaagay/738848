<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class ShopController extends Controller
{

    public function index()
    {
        return Shop::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string'
        ]);
        $shop = Shop::create($validated);
        return $shop;
    }

    public function destroy($id)
    {
        $shop = Shop::findOrFail($id);
        $shop->delete();
    }
}
