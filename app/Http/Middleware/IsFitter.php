<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsFitter
{

    public function handle($request, Closure $next)
    {
        if (Auth::user()->access != 1) {

            return redirect('/');
        }
        return $next($request);

    }

}
