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

        // Define the role-based redirection logic
        $roleRedirects = [
            'admin' => '/admin/dashboard',
            'doctor' => '/doctor/dashboard',
            'lab' => '/lab/dashboard',
            'second_lab' => '/second_lab/dashboard',
            'external_lab' => '/external_lab/dashboard',
        ];

        // Redirect based on the user's role, defaulting to the home route
        return redirect()->intended($roleRedirects[$request->user()->role] ?? RouteServiceProvider::HOME);

        // $request->authenticate();

        // $request->session()->regenerate();

        // if ($request->user()->role === 'admin') {
        //     return redirect()->intended('/admin/dashboard');
        // } elseif ($request->user()->role === 'doctor') {
        //     return redirect()->intended('/doctor/dashboard');
        // } elseif ($request->user()->role === 'lab') {
        //     return redirect()->intended('/lab/dashboard');
        // } elseif ($request->user()->role === 'second_lab') {
        //     return redirect()->intended('/second_lab/dashboard');
        // } elseif ($request->user()->role === 'external_lab') {
        //     return redirect()->intended('/external_lab/dashboard');
        // }
        // return redirect()->intended(RouteServiceProvider::HOME);
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
