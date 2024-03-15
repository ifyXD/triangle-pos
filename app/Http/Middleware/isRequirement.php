<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class isRequirement
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the authenticated user's role is equal to 1 (admin)
        if (auth()->user() && auth()->user()->reg_requirements === 'completed') {
            return $next($request);
        } 
        // If the user's role is not equal to 1, redirect them to the admin route
        return redirect()->route('registration.requirements');
    }
}
