<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        // Mengatur faker ke locale Indonesia secara lokal di factory
        $fakerIndo = \Faker\Factory::create('id_ID');

        return [
            'id'                => (string) Str::ulid(), // Penting agar tidak error default value id
            'name'              => $fakerIndo->name(),   // Nama orang Indonesia
            'username'          => fake()->unique()->userName(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => static::$password ??= Hash::make('123'),
            'remember_token'    => Str::random(10),
            'is_active'         => '1',
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
