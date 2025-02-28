<?php

namespace App\Http\Controllers\Merchant\Auth;

use App\Models\Merchant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PasswordLessAuthController extends Controller
{
    public function store(Request $request)
    {
        //validate email
        $data = $request->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        //check if email exists on database
        $merchant = Merchant::where('email', $data['email'])->first();

        //if not exsits -> trow validation error
        if (!$merchant) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        //if exsits ->send email signed url
        $merchant->sendEmailVerificationNotification();

        //redirect to dashboard
        return back()->with('status', 'Link send to email successfully');
    }

    public function verify($id)
    {
        Auth::guard('merchant')->loginUsingId($id);
        $merchant = Auth::guard('merchant')->user();
        $merchant->email_verified_at = now();
        $merchant->save();
        return redirect()->route('merchants.index');
    }
}
