<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckUser
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
        $routeInfo = $request->route();

        if (Auth::user()->id == array_get($routeInfo[2], 'id')) {
            return $next($request);
        }

        return redirect('/');
    }
}