<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
{
    return view('auth');
}

public function login(Request $request)
{
    $credentials = $request->validate([
        'nickname' => 'required|string',
        'password' => 'required|string',
    ]);

    if (Auth::attempt(['nickname' => $credentials['nickname'], 'password' => $credentials['password']])) {
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    return back()->withErrors([
        'nickname' => 'Credenziali non valide.',
    ]);
}

public function logout()
{
    Auth::logout();
    return redirect('/login');
}
}

// rivedere e testare