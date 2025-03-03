<?php

namespace App\Http\Controllers\MerchantAuth;

use App\Models\User;
use App\Models\Merchant;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('merchant.auth.pages.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
        ]);

        $recaptchaData = $response->json();

        if ($recaptchaData['success'] == false) {
            throw ValidationException::withMessages([
                'g-recaptcha-response' => 'Invalid ReCAPTCHA',
            ]);
        }


        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . Merchant::class],
            'password' => ['required',  Rules\Password::defaults()],
        ]);

        $user = Merchant::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::guard('merchant')->login($user);

        return redirect()->route('merchants.index');
    }
}
