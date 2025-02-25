<?php

namespace App\Http\Controllers\MerchantAuth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\MerchantAuth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user('merchant')->hasVerifiedEmail()) {
            return redirect()->intended(route('merchants.index', absolute: false) . '?verified=1');
        }

        if ($request->user('merchant')->markEmailAsVerified()) {
            event(new Verified($request->user('merchant')));
        }

        return redirect()->intended(route('merchants.index', absolute: false) . '?verified=1');
    }
}
