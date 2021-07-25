<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;


class CheckUserUniqueAuth 
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->user()->token != session()->get('access_token')){
            Auth::logout();
            return redirect()->route('login');
        }
        return $next($request);
    }
}
