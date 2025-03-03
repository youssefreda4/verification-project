<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class Twilio
{
    public static function sendOTP($model)
    {
        $account_sid = env('TWILIO_SID');
        $auth_token = env('TWILIO_TOKEN');
        // In production, these should be environment variables. E.g.:
        // $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]

        // A Twilio number you own with SMS capabilities
        $twilio_number = env('TWILIO_FROM_NUMBER');
        try {

            $client = new Client($account_sid, $auth_token);
            $client->messages->create(
                // Where to send a text message (your cell phone?)
                $model->phone,
                array(
                    'from' => $twilio_number,
                    'body' => 'Your OTP is ' . $model->otp . ' !'
                )
            );
        } catch (TwilioException $e) {
           Log::alert($e->getMessage());
        }
    }
}
