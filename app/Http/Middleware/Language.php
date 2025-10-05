<?php

namespace App\Http\Middleware;

use Closure;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->has('lang')) {
            \App::setlocale($request->session()->get('lang'));
        }

        // dd($request->session('lang'));
        return $next($request);
    }
}
