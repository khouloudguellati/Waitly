<?php

use App\Models\Service;

test('guest cannot access service routes', function () {
    $this->get(route('institution-admin.services.index'))
        ->assertRedirect(route('login'));
});

test('regular user cannot access institution admin service routes', function () {
    $this->actingAs(regularUser())
        ->get(route('institution-admin.services.index'))
        ->assertForbidden();
});

test('institution admin can list their own services', function () {
    $inst = institution();
    $admin = institutionAdmin($inst);
    $svc = service($inst, ['name' => 'Service Carte Identité']);
    $other = service(institution(), ['name' => 'Service Autre Institution']);

    $this->actingAs($admin)
        ->get(route('institution-admin.services.index'))
        ->assertOk()
        ->assertSee('Service Carte Identité')
        ->assertDontSee('Service Autre Institution');
});

test('institution admin can create a service', function () {
    $inst = institution();
    $admin = institutionAdmin($inst);

    $this->actingAs($admin)
        ->post(route('institution-admin.services.store'), [
            'name' => 'Renouvellement Passeport',
            'description' => 'Service de renouvellement',
            'estimated_time' => 15,
            'daily_capacity' => 50,
        ])
        ->assertRedirect(route('institution-admin.services.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('services', [
        'name' => 'Renouvellement Passeport',
        'institution_id' => $inst->id,
    ]);
});

test('service store validates required fields', function () {
    $admin = institutionAdmin();

    $this->actingAs($admin)
        ->post(route('institution-admin.services.store'), [])
        ->assertSessionHasErrors(['name', 'estimated_time']);
});

test('service store validates estimated_time minimum', function () {
    $admin = institutionAdmin();

    $this->actingAs($admin)
        ->post(route('institution-admin.services.store'), [
            'name' => 'Test Service',
            'estimated_time' => 0,
        ])
        ->assertSessionHasErrors('estimated_time');
});

test('institution admin can update their service', function () {
    $inst = institution();
    $admin = institutionAdmin($inst);
    $svc = service($inst);

    $this->actingAs($admin)
        ->put(route('institution-admin.services.update', $svc), [
            'name' => 'Updated Service Name',
            'estimated_time' => 20,
            'is_active' => true,
        ])
        ->assertRedirect(route('institution-admin.services.index'))
        ->assertSessionHas('success');

    expect($svc->fresh()->name)->toBe('Updated Service Name');
});

test('institution admin cannot update service from another institution', function () {
    $admin = institutionAdmin();
    $otherInst = institution();
    $otherSvc = service($otherInst);

    $this->actingAs($admin)
        ->put(route('institution-admin.services.update', $otherSvc), [
            'name' => 'Hacked',
            'estimated_time' => 5,
            'is_active' => true,
        ])
        ->assertForbidden();
});

test('institution admin can delete a service with no waiting tickets', function () {
    $inst = institution();
    $admin = institutionAdmin($inst);
    $svc = service($inst);

    $this->actingAs($admin)
        ->delete(route('institution-admin.services.destroy', $svc))
        ->assertRedirect(route('institution-admin.services.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('services', ['id' => $svc->id]);
});

test('institution admin cannot delete service with waiting tickets', function () {
    $inst = institution();
    $admin = institutionAdmin($inst);
    $svc = service($inst);
    $user = regularUser();

    ticket($user, $svc, ['status' => 'waiting']);

    $this->actingAs($admin)
        ->delete(route('institution-admin.services.destroy', $svc))
        ->assertRedirect()
        ->assertSessionHas('error');

    $this->assertDatabaseHas('services', ['id' => $svc->id]);
});

test('institution admin cannot delete service from another institution', function () {
    $admin = institutionAdmin();
    $otherSvc  = service(institution());

    $this->actingAs($admin)
        ->delete(route('institution-admin.services.destroy', $otherSvc))
        ->assertForbidden();
});