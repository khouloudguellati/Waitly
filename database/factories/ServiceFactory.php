<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\Institution;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        return [
            'institution_id' => Institution::factory(),
            'name'           => $this->faker->words(3, true),
            'description'    => $this->faker->optional()->sentence(),
            'estimated_time' => $this->faker->numberBetween(5, 60),
            'daily_capacity' => $this->faker->optional()->numberBetween(10, 200),
            'is_active'      => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(['is_active' => false]);
    }
}
