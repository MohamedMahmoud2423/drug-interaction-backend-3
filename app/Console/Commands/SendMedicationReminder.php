<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MedicationPlan;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
use Carbon\Carbon;

class SendMedicationReminder extends Command
{
    protected $signature = 'medication:reminder';
    protected $description = 'Send medication reminder emails to patients';

    public function handle()
    {
        $now = Carbon::now()->format('Y-m-d H:i');

        // Split current datetime to match `date` and `time` columns
        [$date, $time] = explode(' ', $now);

        $plans = MedicationPlan::where('date', $date)
            ->where('time', $time)
            ->with('user') // Make sure user relationship is loaded
            ->get();

        if ($plans->isEmpty()) {
            $this->info("No medication reminders at this time: {$now}");
            return;
        }

        foreach ($plans as $plan) {
            $email = $plan->user->email ?? null;

            if ($email) {
                $subject = "⏰ Medication Reminder: {$plan->medication_name}";
                $message = "Hello, this is your reminder to take <strong>{$plan->medication_name}</strong> at <strong>{$plan->time}</strong>. Dosage: {$plan->dosage}.<br>Note: {$plan->note}";

                Mail::to($email)->send(new WelcomeEmail($message, $subject));
                $this->info("Sent reminder to: {$email}");
            } else {
                $this->warn("No email found for user ID: {$plan->user_id}");
            }
        }
    }
}
