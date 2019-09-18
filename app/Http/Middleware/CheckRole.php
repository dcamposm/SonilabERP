<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$role)
    {
        if (! $request->user()){
            return redirect()->route('login');
        }
        
        if (! $request->user()->hasAnyRole($role)) {
            return back()->with('alert', 'WARNING. No tens accés autoritzat.');
        }
        
        return $next($request);
    }
}
