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
        if (auth()->user() && auth()->user()->reg_requirements === null) {
            // return $next($request);
            return $next($request);
        }

        $redirect = '';
        if (auth()->user()->reg_requirements === 1) {
            // If the user's role is not equal to 1, redirect them to the admin route
            $redirect = redirect()->route('registration.requirements-storename');
        } elseif (auth()->user()->reg_requirements === 2) {
            // If the user's role is not equal to 1, redirect them to the admin route
           $redirect = redirect()->route('registration.requirements-permission');
        } elseif (auth()->user()->reg_requirements === 3) {
            // If the user's role is not equal to 1, redirect them to the admin route
            $redirect = redirect()->route('registration.requirements-colorpallete');
        }
        return $redirect;
    }
}
