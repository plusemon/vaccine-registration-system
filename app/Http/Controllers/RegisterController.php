<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Models\VaccineCenter;
use Illuminate\Support\Facades\DB;
use App\Models\VaccinationSchedule;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Notifications\RegistrationSuccessful;
use App\Http\Requests\RegisterUserStoreRequest;

class RegisterController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        $vaccineCenters = VaccineCenter::all();
        return Inertia::render(
            'Register',
            compact('vaccineCenters')
        );
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    /**
     * Handle user registration for vaccination.
     */
    public function store(RegisterUserStoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'nid' => $request->nid,
                'vaccine_center_id' => $request->vaccine_center_id,
                'registration_date' => now(),
                'password' => 'password',
            ]);

            // Assign vaccination schedule
            // Logic to assign the first available date based on center's daily limit and first come first serve
            $scheduleDate = $this->assignAvailableVaccinationDate($user->vaccine_center_id);

            VaccinationSchedule::create([
                'user_id' => $user->id,
                'vaccination_date' => $scheduleDate,
                'status' => 'Scheduled',
            ]);

            // Send registration successful notification
            $user->notify(new RegistrationSuccessful($scheduleDate, $user->vaccineCenter->name));

            DB::commit();
            return redirect(URL::signedRoute('registration.confirmation', ['tracker' => $user->id]));
        } catch (\Throwable $th) {
            DB::rollBack();
        }

        return back()->with('error', 'An error occurred while registering your vaccination. Please try again later.');

    }

    /**
     * Show the registration confirmation page.
     */
    public function show(Request $request): Response
    {
        $userId = $request->input('tracker');
        $user = User::with(['vaccinationSchedule', 'vaccineCenter'])->findOrFail($userId);

        return Inertia::render('Confirmation', [
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'nid' => $user->nid,
                'vaccine_center' => $user->vaccineCenter->name,
                'vaccination_date' => $user->vaccinationSchedule->vaccination_date->toFormattedDateString(),
            ],
        ]);
    }


    /**
     * Assign the first available vaccination date based on center capacity.
     */
    private function assignAvailableVaccinationDate($vaccineCenterId)
    {
        $currentDate = today();
        while (true) {
            // Skip weekends (Friday and Saturday)
            if (in_array($currentDate->dayOfWeek, [5, 6])) { // 5: Friday, 6: Saturday
                $currentDate->addDay();
                continue;
            }

            // Count scheduled users for the center on the current date
            $scheduledCount = VaccinationSchedule::whereHas('user', function ($query) use ($vaccineCenterId) {
                $query->where('vaccine_center_id', $vaccineCenterId);
            })
                ->whereDate('vaccination_date', $currentDate)
                ->count();

            // Get the center's daily limit
            $dailyLimit = VaccineCenter::find($vaccineCenterId)->daily_limit;

            if ($scheduledCount < $dailyLimit) {
                return $currentDate;
            }

            // Move to the next day if the limit is reached
            $currentDate->addDay();
        }
    }
}
