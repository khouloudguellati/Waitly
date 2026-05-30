<?php

use App\Models\Ticket;

test('guest cannot access institution admin ticket routes', function () {
    $this->get(route('institution-admin.tickets.index'))
        ->assertRedirect(route('login'));
});

test('regular user cannot access institution admin ticket routes', function () {
    $this->actingAs(regularUser())
        ->get(route('institution-admin.tickets.index'))
        ->assertForbidden();
});

test('institution admin can view their tickets dashboard', function () {
    $inst = institution();
    $admin = institutionAdmin($inst);

    $this->actingAs($admin)
        ->get(route('institution-admin.tickets.index'))
        ->assertOk();
});

test('institution admin can view tickets by service', function () {
    $inst = institution();
    $admin = institutionAdmin($inst);
    $svc = service($inst);
    $user = regularUser();

    ticket($user, $svc, ['status' => 'waiting']);

    $this->actingAs($admin)
        ->get(route('institution-admin.tickets.by-service', $svc))
        ->assertOk();
});

test('institution admin cannot view tickets for another institution\'s service', function () {
    $admin = institutionAdmin();
    $otherSvc = service(institution());

    $this->actingAs($admin)
        ->get(route('institution-admin.tickets.by-service', $otherSvc))
        ->assertForbidden();
});

test('institution admin can call a waiting ticket', function () {
    $inst = institution();
    $admin = institutionAdmin($inst);
    $svc = service($inst);
    $user = regularUser();
    $t = ticket($user, $svc, ['status' => 'waiting']);

    $this->actingAs($admin)
        ->post(route('institution-admin.tickets.call', $t))
        ->assertRedirect()
        ->assertSessionHas('success');

    expect($t->fresh()->status)->toBe('called')
        ->and($t->fresh()->called_at)->not->toBeNull();
});

test('institution admin cannot call a non-waiting ticket', function () {
    $inst = institution();
    $admin = institutionAdmin($inst);
    $svc = service($inst);
    $user = regularUser();
    $t = ticket($user, $svc, ['status' => 'completed']);

    $this->actingAs($admin)
        ->post(route('institution-admin.tickets.call', $t))
        ->assertRedirect()
        ->assertSessionHas('error');

    expect($t->fresh()->status)->toBe('completed');
});

test('institution admin cannot call ticket from another institution', function () {
    $admin = institutionAdmin();
    $otherInst = institution();
    $otherSvc = service($otherInst);
    $user = regularUser();
    $t = ticket($user, $otherSvc);

    $this->actingAs($admin)
        ->post(route('institution-admin.tickets.call', $t))
        ->assertForbidden();
});

test('institution admin can complete a waiting ticket', function () {
    $inst = institution();
    $admin = institutionAdmin($inst);
    $svc = service($inst);
    $user = regularUser();
    $t = ticket($user, $svc, ['status' => 'waiting']);

    $this->actingAs($admin)
        ->post(route('institution-admin.tickets.complete', $t))
        ->assertRedirect()
        ->assertSessionHas('success');

    expect($t->fresh()->status)->toBe('completed')
        ->and($t->fresh()->completed_at)->not->toBeNull();
});

test('institution admin can complete a called ticket', function () {
    $inst = institution();
    $admin = institutionAdmin($inst);
    $svc = service($inst);
    $user = regularUser();
    $t = ticket($user, $svc, ['status' => 'called', 'called_at' => now()]);

    $this->actingAs($admin)
        ->post(route('institution-admin.tickets.complete', $t))
        ->assertRedirect()
        ->assertSessionHas('success');

    expect($t->fresh()->status)->toBe('completed');
});

test('institution admin cannot complete an already completed ticket', function () {
    $inst = institution();
    $admin = institutionAdmin($inst);
    $svc = service($inst);
    $user = regularUser();
    $t = ticket($user, $svc, ['status' => 'completed', 'completed_at' => now()]);

    $this->actingAs($admin)
        ->post(route('institution-admin.tickets.complete', $t))
        ->assertSessionHas('error');
});

test('institution admin can cancel a waiting ticket', function () {
    $inst = institution();
    $admin = institutionAdmin($inst);
    $svc = service($inst);
    $user = regularUser();
    $t = ticket($user, $svc, ['status' => 'waiting']);

    $this->actingAs($admin)
        ->post(route('institution-admin.tickets.cancel', $t))
        ->assertRedirect()
        ->assertSessionHas('success');

    expect($t->fresh()->status)->toBe('cancelled');
});

test('institution admin cannot cancel an already completed ticket', function () {
    $inst = institution();
    $admin = institutionAdmin($inst);
    $svc = service($inst);
    $user = regularUser();
    $t = ticket($user, $svc, ['status' => 'completed', 'completed_at' => now()]);

    $this->actingAs($admin)
        ->post(route('institution-admin.tickets.cancel', $t))
        ->assertSessionHas('error');

    expect($t->fresh()->status)->toBe('completed');
});