<?php

namespace App\Services;

use App\Models\User;
use App\Models\VaccineCenter;
use Illuminate\Support\Carbon;

class VaccineSchedulerService
{
    /**
     * Schedule a vaccination date for a user based on the vaccine center's capacity.
     * This function assumes 'first come, first serve' scheduling.
     */
    public function scheduleUser(User $user)
    {
        // Get the vaccine center's daily limit
        $center = $user->vaccineCenter;

        // Find the next available date
        $nextAvailableDate = $this->getNextAvailableDate($center);

        // Set the hour to 9 PM
        $nextAvailableDate->setTime(9, 0);

        // Assign the vaccination date to the user
        $user->scheduled_at = $nextAvailableDate;

        $user->save();
    }

    /**
     * Get the next available date for a vaccine center
     * taking into account the daily limit and weekdays.
     */
    private function getNextAvailableDate(VaccineCenter $center)
    {
        $date = Carbon::today(); // Start with today

        while (true) {
            // Ensure the day is a weekday (Sunday to Thursday)
            if (in_array($date->dayOfWeek, [Carbon::FRIDAY, Carbon::SATURDAY])) {
                $date->addDay();
                continue;
            }

            // Count scheduled users for the date
            $countForDate = User::where('vaccine_center_id', $center->id)
                ->whereDate('scheduled_at', $date)
                ->count();

            // If the count is below the center's daily limit, return this date
            if ($countForDate < $center->daily_limit) {
                return $date;
            }

            // Otherwise, move to the next day
            $date->addDay();
        }
    }
}
