<?php

namespace Database\Factories;

use App\Models\Institution;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InstitutionFactory extends Factory
{
    protected $model = Institution::class;

    public function definition(): array
    {
        $name = $this->faker->company();

        return [
            'name'        => $name,
            'slug'        => Str::slug($name),
            'type'        => $this->faker->randomElement(['mairie', 'hopital', 'bureau_gouvernemental', 'autre']),
            'address'     => $this->faker->streetAddress(),
            'city'        => $this->faker->city(),
            'phone'       => $this->faker->phoneNumber(),
            'email'       => $this->faker->optional()->companyEmail(),
            'description' => $this->faker->optional()->sentence(),
            'is_active'   => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(['is_active' => false]);
    }
}
