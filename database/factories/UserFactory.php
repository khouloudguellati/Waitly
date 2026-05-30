<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name'       => fake()->name(),
            'email'      => fake()->unique()->safeEmail(),
            'password'   => static::$password ??= Hash::make('password'),
            'phone'      => fake()->optional()->phoneNumber(),
            'role'       => 'user',
            'is_active'  => true,
            'remember_token' => Str::random(10),
        ];
    }

    public function superAdmin(): static
    {
        return $this->state(['role' => 'super_admin', 'institution_id' => null]);
    }

    public function institutionAdmin(): static
    {
        return $this->state(['role' => 'institution_admin']);
    }

    public function inactive(): static
    {
        return $this->state(['is_active' => false]);
    }
}
