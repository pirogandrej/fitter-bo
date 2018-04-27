<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{

    public function handle($request, Closure $next)
    {
        if ((Auth::user()->access == 1) && (Auth::user()->admin_role == 1)) {
            return $next($request);
        }

        return redirect('/');
    }

}
