<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('login page is accessible to guests', function () {
    $this->get(route('login'))
        ->assertOk()
        ->assertViewIs('auth.login');
});

test('authenticated users are redirected away from login page', function () {
    $this->actingAs(regularUser())
        ->get(route('login'))
        ->assertRedirect();
});

test('super admin is redirected to super-admin dashboard after login', function () {
    $user = superAdmin();

    $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect(route('super-admin.dashboard'));
});

test('institution admin is redirected to institution-admin dashboard after login', function () {
    $user = institutionAdmin();

    $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect(route('institution-admin.dashboard'));
});

test('regular user is redirected to user dashboard after login', function () {
    $user = regularUser();

    $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect(route('user.dashboard'));
});

test('login fails when email is missing', function () {
    $this->post(route('login'), ['password' => 'password'])
        ->assertSessionHasErrors('email');
});

test('login fails when password is missing', function () {
    $this->post(route('login'), ['email' => 'test@test.com'])
        ->assertSessionHasErrors('password');
});

test('login fails with wrong password', function () {
    $user = regularUser();

    $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ])->assertSessionHasErrors('email');
});

test('login fails when email does not exist', function () {
    $this->post(route('login'), [
        'email' => 'nobody@nowhere.com',
        'password' => 'password',
    ])->assertSessionHasErrors('email');
});

test('inactive user cannot login', function () {
    $user = User::factory()->inactive()->create();

    $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertSessionHasErrors('email');

    $this->assertGuest();
});
