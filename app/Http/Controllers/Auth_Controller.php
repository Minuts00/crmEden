<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class Auth_Controller extends Controller
{
    public function showLogin()
{
    return view('auth');
}

public function login(Request $request)
{
    $request->validate([
        'nickname' => 'required',
        'password' => 'required',
    ]);

    $user = User::where('nickname', $request->nickname)->first();

    if ($user && Hash::check($request->password, $user->password)) {
        Auth::login($user);
        return redirect()->intended('/dashboard');
    }

    return back()->withErrors([
        'nickname' => 'Credenziali non valide.',
    ]);
}

public function logout()
{
    Auth::logout();
    return redirect('/auth');
}
}

// rivedere e testare