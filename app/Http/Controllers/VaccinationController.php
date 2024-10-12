<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class VaccinationController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->with(['vaccineCenter:id,name'])
            ->paginate(100);

        return Inertia::render(
            'List',
            compact('users')
        );
    }
}
