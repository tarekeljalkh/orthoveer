<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        if ($request->user()->role === 'super_admin') {
            return redirect()->intended('/super_admin/dashboard');
        } elseif ($request->user()->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        } elseif ($request->user()->role === 'doctor') {
            return redirect()->intended('/doctor/dashboard');
        } elseif ($request->user()->role === 'lab') {
            return redirect()->intended('/lab/dashboard');
        } elseif ($request->user()->role === 'external_lab') {
            return redirect()->intended('/external_lab/dashboard');
        }
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
