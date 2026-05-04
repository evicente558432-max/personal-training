<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {

    // Show login page
    public function showLogin() {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request) {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $role = Auth::user()->role;

            if ($role === 'admin')   return redirect()->route('admin.dashboard');
            if ($role === 'trainer') return redirect()->route('trainer.dashboard');
            if ($role === 'client')  return redirect()->route('client.dashboard');
        }

        return back()->with('error', 'Invalid email or password.');
    }

    // Show register page
    public function showRegister() {
        return view('auth.register');
    }

    // Handle register
    public function register(Request $request) {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:client,trainer',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        Auth::login($user);

        if ($user->role === 'trainer') return redirect()->route('trainer.dashboard');
        return redirect()->route('client.dashboard');
    }

    // Logout
    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}