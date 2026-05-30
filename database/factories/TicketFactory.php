<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Institution;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition(): array
    {
        $service = Service::factory()->create();

        return [
            'user_id'        => User::factory(),
            'institution_id' => $service->institution_id,
            'service_id'     => $service->id,
            'ticket_number'  => $this->faker->numberBetween(1, 999),
            'status'         => 'waiting',
            'called_at'      => null,
            'completed_at'   => null,
        ];
    }

    public function waiting(): static
    {
        return $this->state(['status' => 'waiting', 'called_at' => null, 'completed_at' => null]);
    }

    public function called(): static
    {
        return $this->state(['status' => 'called', 'called_at' => now(), 'completed_at' => null]);
    }

    public function completed(): static
    {
        return $this->state(['status' => 'completed', 'called_at' => now(), 'completed_at' => now()]);
    }

    public function cancelled(): static
    {
        return $this->state(['status' => 'cancelled', 'called_at' => null, 'completed_at' => null]);
    }
}
