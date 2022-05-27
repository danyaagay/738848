<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function token(Request $request)
    {
        $user = new User;
        return $user->getToken($request->only(['login', 'password']));
    }

    public function index()
    {
        return User::get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'login' => 'required|unique:users',
            'password' => 'required|string'
        ]);

        $user = User::create([
            'login' => $validated['login'],
            'password' => Hash::make($validated['password'])
        ]);

        return $user;
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    }
}
