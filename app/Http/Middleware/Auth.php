<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use App\Models\User;

class Auth extends Middleware
{
    protected function authenticate($request, array $guards)
    {
        $token = $request->query('api_token');
        if (empty($token)) $token = $request->input('api_token');
        if (empty($token)) $token = $request->bearerToken();

        $user = User::where('api_token', $token)->first();
        if($token !== NULL && $user) return;

        $this->unauthenticated($request, $guards);
    }
}
