<?php

use App\Http\Controllers\SearchController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::redirect('/', '/register');

// Register new users with the specified vaccination date
Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('register', [RegisteredUserController::class, 'store']);
Route::get('confirmation', [RegisteredUserController::class, 'show'])->name('registration.confirmation');

// Find the user with the specified ID and assign the vaccination date
Route::get('search', [SearchController::class, 'index'])->name('registration.search');
Route::post('search', [SearchController::class, 'store']);

// Additional: list all registered users
use App\Http\Controllers\VaccinationController;

Route::get('/registrations', [VaccinationController::class, 'index'])->name('registrations.index');


