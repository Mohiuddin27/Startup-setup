<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SellerCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if(Auth::user()->role=='seller') {
                if(Auth::user()->is_approved == 1) {
                    if(Auth::user()->roles()->where('role_id', 4)->exists()){
                        return $next($request);
                    }else{
                        return back()->withErrors(['message'=>'Registation failed!']);
                    }
                }else{
                    return back()->withErrors(['message'=>'Account blocked!']);
                }
            }else{
                $role = Auth::user()->role;
                $redirectUrl = config('auth.redirects.' . $role);
                return redirect($redirectUrl);
            }
        }
        return redirect()->route('unauthorized');
    }
}
