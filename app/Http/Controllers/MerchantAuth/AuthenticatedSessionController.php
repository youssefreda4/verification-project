<?php

namespace App\Http\Controllers\MerchantAuth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
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
        return view('merchant.auth.pages.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate('merchant');

        $request->session()->regenerate();

        return redirect()->intended(route('merchants.index', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('merchant')->logout();

        $request->session()->forget('guard.merchant');

        $request->session()->regenerateToken();

        return redirect()->route('merchants.login');
    }
}
