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
    $response->assertStatus(200)
        ->assertInertia(fn(Assert $page) =>
            $page
                ->component('Search')
                ->where(
                    'user.status',
                    'Not Registered'
                ));
});

it('return not scheduled if the user is registered but not yet scheduled', function () {
    // Arrange
    $user = User::factory()->create([
        'nid' => '12345678900000',
        'scheduled_at' => null,
    ]);

    // Act
    $response = $this->post('/search', [
        'nid' => $user->nid,
    ]);

    // Assert
    $response->assertStatus(200)
        ->assertInertia(fn(Assert $page) =>
            $page
                ->component('Search')
                ->where(
                    'user.status',
                    'Not Scheduled'
                ));
});

it('returns scheduled if the user is registered and scheduled', function () {
    // Arrange
    $user = User::factory()->create([
        'nid' => '12345678900000',
        'scheduled_at' => now()->addDay(),
    ]);

    // Act
    $response = $this->post('/search', [
        'nid' => $user->nid,
    ]);

    // Assert
    $response->assertStatus(200)
        ->assertInertia(fn(Assert $page) =>
            $page
                ->component('Search')
                ->where(
                    'user.status',
                    'Scheduled'
                ));
});

it('returns vaccinated if the user scheduled date has passed', function () {
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
    $response->assertStatus(200)
        ->assertInertia(fn(Assert $page) =>
            $page
                ->component('Search')
                ->where(
                    'user.status',
                    'Vaccinated'
                ));
});
