<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->postData = User::factory()->create()->toArray();
});

it('displays the registration view with available vaccine centers', function () {
    // Act
    $response = $this->get(route('register'));

    // Assert
    $response->assertInertia(
        fn(AssertableInertia $page) =>
        $page->component('Register')
            ->has('vaccineCenters', 1)
    );
});

it('successfully registers a user and assigns a vaccination date', function () {

    // Act
    $response = $this->post(route('register'), $this->postData);

    // Assert
    $this->assertDatabaseHas('users', [
        'nid' => $this->postData['nid'],
        'name' => $this->postData['name'],
        'email' => $this->postData['email'],
    ]);

});

it('prevents registering twice with the same NID', function () {
    // Arrange: Register the user once
    $this->post(route('register'), $this->postData);

    // Act: Attempt to register again with the same NID
    $response = $this->post(route('register'), $this->postData);

    // Assert
    $response->assertSessionHasErrors(['nid' => 'The nid has already been taken.']);
});

