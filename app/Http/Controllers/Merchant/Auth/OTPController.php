<?php

namespace App\Http\Controllers\Merchant\Auth;

use App\Models\Merchant;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Twilio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\ValidationException;

class OTPController extends Controller
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

        //if exsits -> generateOTP
        $merchant->generateOTP();

        //send otp using SMS using provider
        Twilio::sendOTP($merchant);

        //redirect to dashboard
        return redirect()->route('merchants.verify.otp.notice', ['email' => Str::toBase64($merchant->email)]);
    }

    public function notice()
    {
        return view('merchant.auth.pages.verify-otp');
    }

    public function verify(Request $request)
    {

        //validate email and otp
        $data = $request->validate([
            'email' => ['required', 'string', 'email'],
            'otp' => ['required', 'size:6'],
        ]);

        //check if email exists on database
        $merchant = Merchant::where('email', $data['email'])->first();

        //if not exsits -> trow validation error
        if (!$merchant) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        //if exsits -> resetOTP
        if ($merchant && $merchant->otp == $data['otp']) {
            if (now() < $merchant->otp_till) {
                $merchant->resetOTP();
                Auth::guard('merchant')->login($merchant);
                return redirect()->route('merchants.index');
            } else {
                throw ValidationException::withMessages([
                    'otp' => 'Expired OTP',
                ]);
            }
        }

        throw ValidationException::withMessages([
            'otp' => 'OTP doesn\'t match',
        ]);
    }

    public function resend(Request $request)
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

        //if exsits -> generateOTP
        $merchant->generateOTP();

        //send otp using SMS using provider
        $merchant->generateOTP();

        //redirect back
        return back()->with('status', 'OTP send successfully');
    }
}
