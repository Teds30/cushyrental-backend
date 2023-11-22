<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


use Twilio\Rest\Client;


class VerifyOTP extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verifyotp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $parameterValue = $this->argument('parameter');
        // Find your Account SID and Auth Token at twilio.com/console
        // and set the environment variables. See http://twil.io/secure
        $sid = getenv("TWILIO_SID");
        $otp_sid = getenv("TWILIO_OTP_SID");
        $token = getenv("TWILIO_TOKEN");
        $twilio = new Client($sid, $token);

        $verification_check = $twilio->verify->v2->services($otp_sid)
            ->verificationChecks
            ->create(
                [
                    "to" => "+639662177561",
                    "code" => "91749"
                ]
            );

        print($verification_check->status);
    }
}
