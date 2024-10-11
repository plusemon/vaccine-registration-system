<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\VaccinationSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\VaccinationReminder;

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
        $targetDate = Carbon::now()->addDays(2)->startOfDay(); // 9 PM today for vaccination tomorrow
        $schedules = VaccinationSchedule::query()
            ->with('user')
            ->where('vaccination_date', $targetDate)
            ->get();

        foreach ($schedules as $schedule) {
            $user = $schedule->user;
            if ($user->email) {
                Mail::to($user->email)->send(new VaccinationReminder($user, $schedule->vaccination_date));
            }
        }

        $this->info('Vaccination reminders sent successfully.');
    }
}
