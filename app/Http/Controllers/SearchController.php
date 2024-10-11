<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SearchController extends Controller
{
    public function index()
    {
        return Inertia::render('Search');
    }

    public function store(Request $request)
    {
        // Validate the input NID
        $request->validate([
            'nid' => 'required|numeric|min:13,max:17,exists:users,nid',
        ]);

        // Retrieve user based on the NID
        $user = User::where('nid', $request->nid)->with('vaccinationSchedule:id,user_id,vaccination_date')->first();

        $status = null;

        $scheduleDate = $user?->vaccinationSchedule?->vaccination_date;

        // Case 1: User not registered
        if (!$user) {
            $status = 'Not Registered';
        }

        // Case 2: User registered but not scheduled yet
        else if (!$scheduleDate) {
            $status = 'Not Scheduled';
        }

        // Case 3: User scheduled for vaccination
        else if (Carbon::now()->lessThan($scheduleDate)) {
            $status = 'Scheduled';
        }

        // Case 4: User has passed the scheduled date (Vaccinated)
        else if (Carbon::now()->greaterThanOrEqualTo($scheduleDate)) {
            $status = 'Vaccinated';
        }

        return Inertia::render('Search', [
            'status' => $status
        ]);

    }
}
