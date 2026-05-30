<?php

use App\Models\User;

test('guest cannot access admin management routes', function () {
    $this->get(route('super-admin.admins.index'))
        ->assertRedirect(route('login'));
});

test('regular user cannot access admin management routes', function () {
    $this->actingAs(regularUser())
        ->get(route('super-admin.admins.index'))
        ->assertForbidden();
});

test('super admin can list institution admins', function () {
    $admin = institutionAdmin();

    $this->actingAs(superAdmin())
        ->get(route('super-admin.admins.index'))
        ->assertOk()
        ->assertSee($admin->name);
});

test('super admin can create an institution admin', function () {
    $inst = institution();

    $this->actingAs(superAdmin())
        ->post(route('super-admin.admins.store'), [
            'name' => 'Admin Karim',
            'email' => 'karim@example.com',
            'institution_id' => $inst->id,
            'password' => 'Password1!',
        ])
        ->assertRedirect(route('super-admin.admins.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('users', [
        'email' => 'karim@example.com',
        'role' => 'institution_admin',
    ]);
});

test('admin store validates unique email', function () {
    $existing = regularUser();
    $inst = institution();

    $this->actingAs(superAdmin())
        ->post(route('super-admin.admins.store'), [
            'name' => 'Test',
            'email' => $existing->email,
            'institution_id' => $inst->id,
            'password' => 'Password1!',
        ])
        ->assertSessionHasErrors('email');
});

test('super admin can update an institution admin', function () {
    $inst = institution();
    $admin = institutionAdmin($inst);

    $this->actingAs(superAdmin())
        ->put(route('super-admin.admins.update', $admin), [
            'name' => 'Updated Name',
            'email' => $admin->email,
            'institution_id' => $inst->id,
            'is_active' => true,
        ])
        ->assertRedirect(route('super-admin.admins.index'))
        ->assertSessionHas('success');

    expect($admin->fresh()->name)->toBe('Updated Name');
});

test('super admin can deactivate an institution admin', function () {
    $admin = institutionAdmin();
    $inst = $admin->institution;

    $this->actingAs(superAdmin())
        ->put(route('super-admin.admins.update', $admin), [
            'name' => $admin->name,
            'email' => $admin->email,
            'institution_id' => $inst->id,
            'is_active' => false,
        ]);

    expect($admin->fresh()->is_active)->toBeFalse();
});

test('super admin can delete an institution admin', function () {
    $admin = institutionAdmin();

    $this->actingAs(superAdmin())
        ->delete(route('super-admin.admins.destroy', $admin))
        ->assertRedirect(route('super-admin.admins.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('users', ['id' => $admin->id]);
});

test('super admin cannot delete a non-admin user via admin route', function () {
    $user = regularUser();

    $this->actingAs(superAdmin())
        ->delete(route('super-admin.admins.destroy', $user))
        ->assertNotFound();
});