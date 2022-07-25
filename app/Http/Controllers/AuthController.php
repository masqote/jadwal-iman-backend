<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Authentication passed...
            return redirect()->intended('dashboard');
        }

        return back()->with('Error', 'Gagal Login!')->withInput();
        
    }
}
