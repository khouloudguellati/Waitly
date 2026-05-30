<?php

test('authenticated user can logout', function () {
    $user = regularUser();

    $this->actingAs($user)
        ->post(route('logout'))
        ->assertRedirect('/');

    $this->assertGuest();
});

test('guest cannot access logout route', function () {
    $this->post(route('logout'))
        ->assertRedirect(route('login'));
});
