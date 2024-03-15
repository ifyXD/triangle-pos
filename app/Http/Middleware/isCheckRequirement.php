<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isCheckRequirement
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         // Check if the authenticated user's role is equal to 1 (admin)
         if (auth()->user() && auth()->user()->reg_requirements === 'completed') {
            // return $next($request);
            return redirect()->route('home');
        } 
        // If the user's role is not equal to 1, redirect them to the admin route
        
        return $next($request);
    }
}
