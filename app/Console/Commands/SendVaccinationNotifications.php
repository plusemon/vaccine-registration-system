<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Console\Command;
use App\Mail\VaccinationReminder;
use Illuminate\Support\Facades\Mail;

class SendVaccinationNotifications extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'notifications:send-vaccination-reminders';

    /**
     * The console command description.
     */
    protected $description = 'Send vaccination reminders to users at 9 PM before their scheduled date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $targetDate = Carbon::now()->addDay(); // 9 PM today for vaccination tomorrow
        $schedules = User::query()
            ->whereDate('vaccination_date', $targetDate)
            ->get();

        foreach ($schedules as $user) {
            if ($user->email) {
                Mail::to($user->email)->send(new VaccinationReminder($user));
            }
        }

        $this->info('Vaccination reminders sent successfully.');
    }
}
