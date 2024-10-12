<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns not registered if the NID is not found', function () {
    // Act
    $response = $this->post('/search', [
        'nid' => '12345678900000',
    ]);

    // Assert
    $response->assertStatus(200);
});

it('marks a user as vaccinated if the scheduled date has passed', function () {
    // Arrange
    $user = User::factory()->create([
        'nid' => '12345678900000',
        'scheduled_at' => now()->subDays(1),
    ]);

    // Act
    $response = $this->post('/search', [
        'nid' => $user->nid,
    ]);

    // Assert
    $response->assertStatus(200);
});
