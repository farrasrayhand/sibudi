<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('guestbook.index');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($request->username === 'admin' && $request->password === 'admin123') {
            session(['admin_logged_in' => true, 'admin_name' => 'Administrator']);
            return redirect()->route('guestbook.index')->with('success', 'Login berhasil');
        }

        return back()->withErrors(['credentials' => 'Username atau password salah'])->withInput();
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login')->with('success', 'Logout berhasil');
    }
}

