<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\VaccinationController;

Route::redirect('/', '/register');

// Register new users with the specified vaccination date
Route::get('register', [RegisterController::class, 'create'])->name('register');
Route::post('register', [RegisterController::class, 'store']);
Route::get('confirmation', [RegisterController::class, 'show'])->name('registration.confirmation');

// Find the user with the specified ID and assign the vaccination date
Route::get('search', [SearchController::class, 'index'])->name('registration.search');
Route::post('search', [SearchController::class, 'store']);

// Additional: list all registered users/registrations
Route::get('/registrations', [VaccinationController::class, 'index'])->name('registrations.index');


