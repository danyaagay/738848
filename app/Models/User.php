<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'login',
        'email',
        'password',
        'api_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'api_token',
    ];

    public function getToken($request) {
        $user = User::where('login', $request['login'])->first();
        if (!$user) {
            return response('User does not exist', 422);
        }

        if (Hash::check($request['password'], $user['password'])) {
            $token = Str::random(60);

            $user->forceFill([
                'api_token' => $token,
            ])->save();
            
            return $token;
        } else {
            return response('Password is not correct', 422);
        }
    }
}
