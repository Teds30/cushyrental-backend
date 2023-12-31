<?php

namespace App\Console\Commands;

use App\Models\Notification;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Twilio\Rest\Client;

class CheckRentalDueDate extends Command
{

    protected $signature = 'rental:check-due-date';
    protected $description = 'Check rental due dates 3 days before the rental month';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get today's date
        $today = Carbon::now();

        print("[$today]checking rental due dates.");

        // Calculate the date 3 days before the rental month
        $threeDaysBeforeRentalMonth = $today->copy()->addDays(3);

        $rentalsDue = DB::table('rentals')
            ->where('due_date', $threeDaysBeforeRentalMonth->format('d'))
            ->get();

        // Perform actions based on $rentalsDue
        foreach ($rentalsDue as $rental) {
            $rental = Rental::get()->where('id', $rental->id)->first();
            $unit_name = $rental->unit->name;
            $tenant = $rental->user;
            $landlord = $rental->unit->landlord;
            $amount = $rental->monthly_amount;

            $due_date = $threeDaysBeforeRentalMonth->format('F j');
            $fields = [
                'title' => 'Payment Due Date Reminder',
                'message' => "This is a reminder of your incoming rental payment for the unit $unit_name due on $due_date",
                'redirect_url' => '',
                'user_id' => $tenant->id,
            ];

            $res = Notification::create($fields);

            $tenant_name = $tenant->first_name . " " . $tenant->last_name;
            $landlord_fields = [
                'title' => 'Payment Due Date Reminder',
                'message' => "This is a reminder that $tenant_name has an upcoming due date for rental payment for Unit $unit_name",
                'redirect_url' => '',
                'user_id' => $landlord->id,
            ];

            $landlord_res = Notification::create($landlord_fields);

            $landlord_number = $rental->user->phone_number;
            $landlord_name = $landlord->first_name . " " . $landlord->last_name;
            // print($landlord_number);

            if ($tenant->phone_number) {

                // $sid    = env('TWILIO_SID');
                // $token  = env('TWILIO_TOKEN');
                // $twilio = new Client($sid, $token);

                // $message = $twilio->messages
                //     ->create(
                //         $tenant->phone_number, // to
                //         array(
                //             "from" => "+19045496873",
                //             // "body" => "This is a reminder of your rental payment for the unit '$unit_name'."
                //             "body" => "Prepare your payment before the due.\nLandlord Name: $landlord_name\nAmount: ₱$amount"
                //         )
                //     );

                // print($message);
                print("\n===================\n");
                print("\n===================\nTO: $tenant->phone_number; \nPrepare your payment before the due. \nLandlord Name: $landlord_name \nAmount: ₱$amount\n");
            }
        }
    }
}
