<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 *
 * Factory class for generating User model instances.
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     *
     * @var string|null The hashed password used for the User model instances.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed> The default attributes for the User model.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(), // Generates a random name for the User model.
            'email' => fake()->unique()->safeEmail(), // Generates a unique and safe email address for the User model.
            'email_verified_at' => now(), // Sets the email verification timestamp to the current time.
            'password' => static::$password ??= Hash::make('password'), // Hashes a default password for the User model.
            'remember_token' => Str::random(10), // Generates a random remember token for the User model.
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static The factory instance with unverified email state.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null, // Sets the email verification timestamp to null for the User model.
        ]);
    }
}
