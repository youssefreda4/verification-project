<?php

namespace App\Models;

use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\MerchantEmailVerification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Merchant extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    public function sendEmailVerificationNotification()
    {
        if (config('verification.way') == 'email') {
            $url = URL::temporarySignedRoute(
                'merchants.verification.verify',
                now()->addMinutes(30),
                [
                    'id' => $this->getKey(),
                    'hash' => sha1($this->getEmailForVerification()),
                ]
            );
            $this->notify(new MerchantEmailVerification($url));
        }

        if (config('verification.way') == 'cvt') {
            $this->generateVerficationToken();
            $url = route('merchants.verification.verify', [
                'id' =>  $this->getKey(),
                'token' => $this->verification_token,
            ]);

            $this->notify(new MerchantEmailVerification($url));
        }

        if (config('verification.way') == 'passwordless') {
            $url = URL::temporarySignedRoute(
                'merchants.login.verify',
                now()->addMinutes(30),
                [
                    'id' => $this->getKey(),
                ]
            );
            $this->notify(new MerchantEmailVerification($url));
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verification_token',
        'verification_token_till',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    //Custom Verification Token
    public function generateVerficationToken()
    {
        if (config('verification.way') == 'cvt') {
            $this->verification_token = Str::random(40);
            $this->verification_token_till = now()->addMinutes(60);
            $this->save();
        }
    }

    public function verifyUsingVerficationToken()
    {
        if (config('verification.way') == 'cvt') {
            $this->email_verified_at = now();
            $this->verification_token = null;
            $this->verification_token_till = null;
            $this->save();
        }
    }

    //OTP Verification
    public function generateOTP()
    {
        if (config('verification.way') == 'otp') {
            $this->otp = rand(111111, 999999);
            $this->otp_till = now()->addMinutes(60);
            $this->save();
        }
    }

    public function resetOTP()
    {
        if (config('verification.way') == 'otp') {
            $this->otp = null;
            $this->otp_till = null;
            $this->save();
        }
    }
}
