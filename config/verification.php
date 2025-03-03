<?php

return [

    //VERIFICATION TECHNIQUES
    //'default' => Without any VERIFICATION
    //'email' => With email verification using signed URLs (register) 
    //'cvt' => With Custom Verification Token 
    //'passwordless' => With passwordless Verification  (login)
    //'otp' => With one time password Verification  (login) min 6 character

    'way' => 'default',

    //OTP PROVIDERS
    //'twilio' OR 'vonage'

    'otp_provider'=>'twilio',


];
