<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()) {
            if (Auth::user()->isAdmin() || Auth::user()->isSuperAdmin()) {
                if (Auth::user()->is_active) {
                    return $next($request);
                } else {
                    return redirect('/account-disabled');
                }
            } else {
                return redirect('/home');
            }
        } else {
            return redirect('/login');
        }
    }
}
