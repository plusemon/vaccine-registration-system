<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Models\VaccineCenter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Services\VaccineSchedulerService;
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
    public function store(RegisterUserStoreRequest $request, VaccineSchedulerService $schedulerService)
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'nid' => $request->nid,
                'vaccine_center_id' => $request->vaccine_center_id,
                'password' => 'password',
            ]);

            // Schedule vaccination for the user
            $schedulerService->scheduleUser($user);

            // Send registration successful notification
            $user->notify(new RegistrationSuccessful($user));

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
        $user = User::with(['vaccineCenter'])->findOrFail($userId);

        return Inertia::render('Confirmation', [
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'nid' => $user->nid,
                'vaccine_center_name' => $user->vaccineCenter->name,
                'scheduled_at' => $user->scheduled_at->format('D, d M Y h:i A'),
            ],
        ]);
    }
}
