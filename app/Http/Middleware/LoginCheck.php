<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::check()) {
            if(Auth::user()->is_approved == 1) {
                $role = Auth::user()->role;
                $redirectUrl = config('auth.redirects.' . $role);
                return redirect($redirectUrl);
            }
            return back()->withErrors(['message'=>'Account blocked!']);
        }
        return $next($request);
    }
}
