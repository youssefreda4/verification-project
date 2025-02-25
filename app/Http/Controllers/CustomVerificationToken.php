<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CustomVerificationToken extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function notice(Request $request)
    {
        return $request->user('merchant')->hasVerifiedEmail()
            ? redirect()->intended(route('dashboard', absolute: false))
            : view('merchant.auth.pages.verify-email');
    }

    /**
     * Mark the authenticated user's email address as verified.
     */
    public function verify(Request $request)
    {
        $merchant = Merchant::where('verification_token', $request->token)->firstOrFail();

        if (now() < $merchant->verification_token_till) {
            $merchant->verifyUsingVerficationToken();
            return redirect()->route('merchants.index');
        }

        return redirect()->route('merchants.verification.notice')->with('status', 'verification-token-expired');
    }

    /**
     * Send a new email verification notification.
     */
    public function resend(Request $request)
    {
        if ($request->user('merchant')->hasVerifiedEmail()) {
            return redirect()->intended(route('merchants.index', absolute: false));
        }

        $request->user('merchant')->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
