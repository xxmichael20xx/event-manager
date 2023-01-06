<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SystemAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in
        if ( ! auth()->user() ) return redirect('login');

        // Check if user role is "admin"
        if ( auth()->user()->role !== 'admin' ) return redirect('/');

        return $next($request);
    }
}
