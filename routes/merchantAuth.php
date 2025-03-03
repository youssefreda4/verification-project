<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomVerificationToken;
use App\Http\Controllers\Merchant\Auth\OTPController;
use App\Http\Controllers\Merchant\Auth\PasswordLessAuthController;
use App\Http\Controllers\MerchantAuth\PasswordController;
use App\Http\Controllers\MerchantAuth\NewPasswordController;
use App\Http\Controllers\MerchantAuth\VerifyEmailController;
use App\Http\Controllers\MerchantAuth\RegisteredUserController;
use App\Http\Controllers\MerchantAuth\PasswordResetLinkController;
use App\Http\Controllers\MerchantAuth\ConfirmablePasswordController;
use App\Http\Controllers\MerchantAuth\AuthenticatedSessionController;
use App\Http\Controllers\MerchantAuth\EmailVerificationPromptController;
use App\Http\Controllers\MerchantAuth\EmailVerificationNotificationController;

Route::middleware('guest:merchant')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    if (config('verification.way') == 'passwordless') {
        Route::post('login', [PasswordLessAuthController::class, 'store']);

        Route::get('login-verify-email/{id}', [PasswordLessAuthController::class, 'verify'])
            ->middleware(['signed', 'throttle:6,1'])
            ->name('login.verify');
    } elseif (config('verification.way') == 'otp') {
        Route::post('login', [OTPController::class, 'store']);

        Route::get('/verify-otp/{email}', [OTPController::class, 'notice'])->name('verify.otp.notice');

        Route::post('verify-otp', [OTPController::class, 'verify'])->name('verify.otp');

        Route::post('resend-otp', [OTPController::class, 'resend'])->name('resend.otp');
    } else {
        Route::post('login', [AuthenticatedSessionController::class, 'store']);
    }
});

Route::middleware(['merchant'])->group(function () {
    if (config('verification.way') == 'email') {
        Route::get('verify-email', EmailVerificationPromptController::class)
            ->name('verification.notice');

        Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');

        Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware('throttle:6,1')
            ->name('verification.send');
    }

    if (config('verification.way') == 'cvt') {
        Route::get('verify-email', [CustomVerificationToken::class, 'notice'])
            ->name('verification.notice');

        Route::get('verify-email/{id}/{token}', [CustomVerificationToken::class, 'verify'])
            ->middleware('throttle:6,1')
            ->name('verification.verify');

        Route::post('email/verification-notification', [CustomVerificationToken::class, 'resend'])
            ->middleware('throttle:6,1')
            ->name('verification.send');
    }

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
