<?php

use Illuminate\Support\Facades\Mail;
use App\Mail\VaccinationReminder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('sends email notifications to users with scheduled vaccinations', function () {
    // Arrange
    Mail::fake();

    $user = User::factory()->create([
        'scheduled_at' => now()->addDay(),
    ]);

    // Act
    $this->artisan('schedule:run');

    // Assert
    Mail::assertSent(VaccinationReminder::class, function ($mail) use ($user) {
        return $mail->hasTo($user->email);
    });
});
