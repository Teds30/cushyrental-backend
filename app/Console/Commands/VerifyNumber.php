<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


use Twilio\Rest\Client;


class VerifyNumber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verifynumber';

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

        // Find your Account SID and Auth Token at twilio.com/console
        // and set the environment variables. See http://twil.io/secure
        $sid = getenv("TWILIO_SID");
        $token = getenv("TWILIO_TOKEN");
        $twilio = new Client($sid, $token);

        $verification = $twilio->verify->v2->services("VA952ea9c3c3eb00f4c19575886589860d")
            ->verifications
            ->create("+639662177561", "sms");

        print($verification->status);
    }
}
