<?php

use App\Models\User;

test('register page is accessible to guests', function () {
    $this->get(route('register'))
        ->assertOk()
        ->assertViewIs('auth.register');
});

test('user can register with valid data', function () {
    $this->post(route('register'), [
        'name' => 'Ahmed Benali',
        'email' => 'ahmed@example.com',
        'phone' => '0551234567',
        'password' => 'Password1!',
        'password_confirmation' => 'Password1!',
    ])->assertRedirect(route('user.dashboard'));

    $this->assertAuthenticated();

    $this->assertDatabaseHas('users', [
        'email' => 'ahmed@example.com',
        'role' => 'user',
    ]);
});

test('new user defaults to role user and is_active true', function () {
    $this->post(route('register'), [
        'name' => 'Sara Bouzid',
        'email' => 'sara@example.com',
        'password' => 'Password1!',
        'password_confirmation' => 'Password1!',
    ]);

    $user = User::where('email', 'sara@example.com')->first();

    expect($user->role)->toBe('user')
        ->and($user->is_active)->toBeTrue();
});

test('registration fails when name is missing', function () {
    $this->post(route('register'), [
        'email' => 'test@example.com',
        'password' => 'Password1!',
        'password_confirmation' => 'Password1!',
    ])->assertSessionHasErrors('name');
});

test('registration fails with duplicate email', function () {
    $existing = regularUser();

    $this->post(route('register'), [
        'name' => 'Other User',
        'email' => $existing->email,
        'password' => 'Password1!',
        'password_confirmation' => 'Password1!',
    ])->assertSessionHasErrors('email');
});

test('registration fails when passwords do not match', function () {
    $this->post(route('register'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'Password1!',
        'password_confirmation' => 'DifferentPassword!',
    ])->assertSessionHasErrors('password');
});

test('registration fails when password is too short', function () {
    $this->post(route('register'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'short',
        'password_confirmation' => 'short',
    ])->assertSessionHasErrors('password');
});
