<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function login(): View
    {
        return view('auth.login');
    }

    public function authenticate(LoginRequest $request): RedirectResponse
    {
        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'The provided credentials do not match our records.'])
                ->onlyInput('email');
        }

        if (! $request->user()->isActive()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors(['email' => 'Your account has been suspended.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return $request->user()->isAdmin()
            ? redirect()->intended(route('admin.dashboard'))
            : redirect()->intended(route('menu.index'));
    }

    public function register(): View
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'password' => $request->validated('password'),
            'role' => UserRole::User,
            'status' => 'active',
        ]);

        Auth::login($user);

        return redirect()->route('menu.index');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('menu.index');
    }
}
