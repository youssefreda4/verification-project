<?php

namespace App\Http\Controllers\MerchantAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user('merchant')->hasVerifiedEmail()) {
            return redirect()->intended(route('merchants.index', absolute: false));
        }

        $request->user('merchant')->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
