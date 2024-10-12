<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows users to check their vaccination status', function () {
    // Arrange
    $user = User::factory()->create([
        'nid' => '1234567890',
        'scheduled_at' => now()->addDays(2),
    ]);

    // Act
    $response = $this->get('/search?nid=1234567890');

    // Assert
    $response->assertStatus(200)
        ->assertJson([
            'status' => 'Scheduled',
            'scheduled_at' => $user->scheduled_at->toDateString(),
        ]);
});

it('returns not registered if the NID is not found', function () {
    // Act
    $response = $this->get('/search?nid=0987654321');

    // Assert
    $response->assertStatus(200)
        ->assertJson([
            'status' => 'Not registered',
        ]);
});

it('marks a user as vaccinated if the scheduled date has passed', function () {
    // Arrange
    $user = User::factory()->create([
        'nid' => '1234567890',
        'scheduled_at' => now()->subDays(1),
    ]);

    // Act
    $response = $this->get('/search?nid=1234567890');

    // Assert
    $response->assertStatus(200)
        ->assertJson([
            'status' => 'Vaccinated',
        ]);
});
