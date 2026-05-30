<?php

use App\Models\Institution;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('User', function () {

    it('correctly identifies a super admin', function () {
        $user = User::factory()->create(['role' => 'super_admin']);
        expect($user->isSuperAdmin())->toBeTrue()
            ->and($user->isInstitutionAdmin())->toBeFalse()
            ->and($user->isUser())->toBeFalse();
    });

    it('correctly identifies an institution admin', function () {
        $user = User::factory()->create(['role' => 'institution_admin']);
        expect($user->isInstitutionAdmin())->toBeTrue()
            ->and($user->isSuperAdmin())->toBeFalse();
    });

    it('correctly identifies a regular user', function () {
        $user = User::factory()->create(['role' => 'user']);
        expect($user->isUser())->toBeTrue()
            ->and($user->isSuperAdmin())->toBeFalse();
    });

    it('has a tickets relationship', function () {
        $inst = Institution::factory()->create();
        $svc = Service::factory()->create(['institution_id' => $inst->id]);
        $user = User::factory()->create(['role' => 'user']);

        Ticket::factory()->create([
            'user_id' => $user->id,
            'service_id' => $svc->id,
            'institution_id' => $inst->id,
        ]);

        expect($user->tickets)->toHaveCount(1);
    });
});

describe('Institution', function () {

    it('auto-generates a slug on creation', function () {
        $inst = Institution::factory()->create(['name' => 'Mairie de Constantine', 'slug' => '']);

        $inst2 = Institution::create([
            'name' => 'Hôpital Central Alger',
            'type' => 'hopital',
            'address' => '1 Rue',
            'city' => 'Alger',
            'phone' => '021000000',
        ]);

        expect($inst2->slug)->toBe('hopital-central-alger');
    });

    it('scopeActive returns only active institutions', function () {
        Institution::factory()->count(2)->create(['is_active' => true]);
        Institution::factory()->count(3)->create(['is_active' => false]);

        expect(Institution::active()->count())->toBe(2);
    });

    it('has services relationship', function () {
        $inst = Institution::factory()->create();
        Service::factory()->count(3)->create(['institution_id' => $inst->id]);

        expect($inst->services)->toHaveCount(3);
    });
});

describe('Service', function () {

    it('scopeActive returns only active services', function () {
        $inst = Institution::factory()->create();
        Service::factory()->count(2)->create(['institution_id' => $inst->id, 'is_active' => true]);
        Service::factory()->count(1)->create(['institution_id' => $inst->id, 'is_active' => false]);

        expect(Service::active()->count())->toBe(2);
    });

    it('getNextTicketNumber returns 1 when no tickets today', function () {
        $inst = Institution::factory()->create();
        $svc = Service::factory()->create(['institution_id' => $inst->id]);

        expect($svc->getNextTicketNumber())->toBe(1);
    });

    it('getNextTicketNumber increments correctly', function () {
        $inst = Institution::factory()->create();
        $svc = Service::factory()->create(['institution_id' => $inst->id]);
        $user = User::factory()->create();

        Ticket::factory()->create([
            'user_id' => $user->id,
            'service_id' => $svc->id,
            'institution_id' => $inst->id,
            'ticket_number' => 5,
            'created_at' => today(),
        ]);

        expect($svc->getNextTicketNumber())->toBe(6);
    });

    it('getCurrentQueueCount counts only waiting tickets for today', function () {
        $inst = Institution::factory()->create();
        $svc = Service::factory()->create(['institution_id' => $inst->id]);
        $user = User::factory()->create();

        Ticket::factory()->count(3)->create([
            'user_id' => $user->id,
            'service_id' => $svc->id,
            'institution_id' => $inst->id,
            'status' => 'waiting',
            'created_at' => today(),
        ]);

        Ticket::factory()->create([
            'user_id' => $user->id,
            'service_id' => $svc->id,
            'institution_id' => $inst->id,
            'status' => 'completed',
            'created_at' => today(),
        ]);

        expect($svc->getCurrentQueueCount())->toBe(3);
    });
});

describe('Ticket', function () {

    it('getFormattedTicketNumber formats correctly', function () {
        $inst = Institution::factory()->create();
        $svc = Service::factory()->create(['institution_id' => $inst->id, 'name' => 'Passeport']);
        $user = User::factory()->create();
        $ticket = Ticket::factory()->create([
            'user_id' => $user->id,
            'service_id' => $svc->id,
            'institution_id' => $inst->id,
            'ticket_number' => 7,
        ]);

        expect($ticket->getFormattedTicketNumber())->toBe('PAS-007');
    });

    it('getPositionInQueue returns correct position', function () {
        $inst = Institution::factory()->create();
        $svc = Service::factory()->create(['institution_id' => $inst->id]);
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        $first = Ticket::factory()->create([
            'user_id' => $user->id,
            'service_id' => $svc->id,
            'institution_id' => $inst->id,
            'status' => 'waiting',
            'created_at' => now()->subMinutes(5),
        ]);

        $second = Ticket::factory()->create([
            'user_id' => $user2->id,
            'service_id' => $svc->id,
            'institution_id' => $inst->id,
            'status' => 'waiting',
            'created_at' => now(),
        ]);

        expect($first->getPositionInQueue())->toBe(1)
            ->and($second->getPositionInQueue())->toBe(2);
    });

    it('scopeWaiting returns only waiting tickets', function () {
        $inst = Institution::factory()->create();
        $svc = Service::factory()->create(['institution_id' => $inst->id]);
        $user = User::factory()->create();

        Ticket::factory()->count(2)->create([
            'user_id' => $user->id,
            'service_id' => $svc->id,
            'institution_id' => $inst->id,
            'status' => 'waiting',
        ]);
        Ticket::factory()->create([
            'user_id' => $user->id,
            'service_id' => $svc->id,
            'institution_id' => $inst->id,
            'status' => 'completed',
        ]);

        expect(Ticket::waiting()->count())->toBe(2);
    });
});
