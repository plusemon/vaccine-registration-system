<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        return Inertia::render('Search');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nid' => ['required', 'numeric', 'digits_between:10,17'],
        ], [
            'nid' => 'Enter your national ID (10 to 17 digits)',
        ]);

        $user = User::query()
            ->where('nid', $request->nid)
            ->first();

        return Inertia::render('Search', [
            'user' => [
                'name' => $user?->name,
                'nid' => $user?->nid,
                'vaccine_center_name' => $user?->vaccineCenter?->name,
                'status' => $user?->status ?? 'Not Registered',
                'scheduled_at' => $user?->scheduled_at?->format('D, d M Y h:i A'),
            ]
        ]);

    }
}
