<?php

use App\Models\Institution;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class)->in('Feature', 'Unit');
uses(RefreshDatabase::class)->in('Feature', 'Unit');

function superAdmin(): User
{
    return User::factory()->create([
        'role' => 'super_admin',
        'is_active' => true,
    ]);
}

function institutionAdmin(?Institution $institution = null): User
{
    $institution ??= institution();

    return User::factory()->create([
        'role' => 'institution_admin',
        'institution_id' => $institution->id,
        'is_active' => true,
    ]);
}

function regularUser(): User
{
    return User::factory()->create([
        'role' => 'user',
        'is_active' => true,
    ]);
}

function institution(array $attrs = []): Institution
{
    return Institution::factory()->create(array_merge([
        'is_active' => true,
    ], $attrs));
}

function service(?Institution $institution = null, array $attrs = []): Service
{
    $institution ??= institution();

    return Service::factory()->create(array_merge([
        'institution_id' => $institution->id,
        'is_active'      => true,
        'estimated_time' => 10,
    ], $attrs));
}

function ticket(User $user, Service $service, array $attrs = []): Ticket
{
    return Ticket::factory()->create(array_merge([
        'user_id'        => $user->id,
        'institution_id' => $service->institution_id,
        'service_id'     => $service->id,
        'status'         => 'waiting',
    ], $attrs));
}
