<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'password' => ['required', 'string'],
        ]);

        if (!hash_equals((string) config('license.admin_password'), $data['password'])) {
            return back()->withErrors(['password' => 'Invalid portal password.']);
        }

        $request->session()->put('license_portal_authenticated', true);

        return redirect()->route('licenses.index');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('license_portal_authenticated');

        return redirect()->route('login');
    }
}
