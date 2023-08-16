<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request) {
        try {

            // $credentials = $request->validate([
            //     'email' => 'required|email',
            //     'password' => 'required',
            // ]);

            // if (Auth::attempt($credentials)) {
            //     $role = Auth::user()->role;
            //     $redirectUrl = config('auth.redirects.' . $role);
            //     return redirect($redirectUrl);
            // }
            // return redirect()->route('unauthorized');
            return view('auth.login');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function login_submit(Request $request){
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (Auth::attempt($credentials)) {
                $role = Auth::user()->role;
                $redirectUrl = config('auth.redirects.' . $role);
                return redirect($redirectUrl);
            }
            return redirect()->route('unauthorized');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
