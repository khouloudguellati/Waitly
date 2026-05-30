<?php

use App\Models\Institution;

test('guest cannot access super-admin institution routes', function () {
    $this->get(route('super-admin.institutions.index'))
        ->assertRedirect(route('login'));
});

test('regular user cannot access super-admin institution routes', function () {
    $this->actingAs(regularUser())
        ->get(route('super-admin.institutions.index'))
        ->assertForbidden();
});

test('institution admin cannot access super-admin institution routes', function () {
    $this->actingAs(institutionAdmin())
        ->get(route('super-admin.institutions.index'))
        ->assertForbidden();
});

test('super admin can list institutions', function () {
    institution(['name' => 'Mairie Alger']);
    institution(['name' => 'Hopital Central']);

    $this->actingAs(superAdmin())
        ->get(route('super-admin.institutions.index'))
        ->assertOk()
        ->assertSee('Mairie Alger')
        ->assertSee('Hopital Central');
});

test('super admin can view institution create form', function () {
    $this->actingAs(superAdmin())
        ->get(route('super-admin.institutions.create'))
        ->assertOk();
});

test('super admin can create an institution', function () {
    $this->actingAs(superAdmin())
        ->post(route('super-admin.institutions.store'), [
            'name' => 'Mairie de Sétif',
            'type' => 'mairie',
            'address' => '1 Rue Principale',
            'city' => 'Sétif',
            'phone' => '036123456',
        ])
        ->assertRedirect(route('super-admin.institutions.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('institutions', [
        'name' => 'Mairie de Sétif',
        'type' => 'mairie',
    ]);
});

test('institution store validates required fields', function () {
    $this->actingAs(superAdmin())
        ->post(route('super-admin.institutions.store'), [])
        ->assertSessionHasErrors(['name', 'type', 'address', 'city', 'phone']);
});

test('institution store validates type enum', function () {
    $this->actingAs(superAdmin())
        ->post(route('super-admin.institutions.store'), [
            'name' => 'Test',
            'type' => 'invalid_type',
            'address' => 'Addr',
            'city' => 'City',
            'phone' => '0550000000',
        ])
        ->assertSessionHasErrors('type');
});

test('super admin can update an institution', function () {
    $inst = institution(['name' => 'Old Name']);

    $this->actingAs(superAdmin())
        ->put(route('super-admin.institutions.update', $inst), [
            'name' => 'New Name',
            'type' => 'hopital',
            'address' => '5 Rue Nouvelle',
            'city' => 'Oran',
            'phone' => '041000000',
            'is_active' => true,
        ])
        ->assertRedirect(route('super-admin.institutions.index'))
        ->assertSessionHas('success');

    expect($inst->fresh()->name)->toBe('New Name');
});

test('super admin can delete an institution with no waiting tickets', function () {
    $inst = institution();

    $this->actingAs(superAdmin())
        ->delete(route('super-admin.institutions.destroy', $inst))
        ->assertRedirect(route('super-admin.institutions.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('institutions', ['id' => $inst->id]);
});

test('super admin cannot delete institution with waiting tickets', function () {
    $inst = institution();
    $svc = service($inst);
    $user = regularUser();

    ticket($user, $svc, ['status' => 'waiting']);

    $this->actingAs(superAdmin())
        ->delete(route('super-admin.institutions.destroy', $inst))
        ->assertRedirect()
        ->assertSessionHas('error');

    $this->assertDatabaseHas('institutions', ['id' => $inst->id]);
});