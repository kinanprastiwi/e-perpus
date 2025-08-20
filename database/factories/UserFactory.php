<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_user' => 'AD' . Str::padLeft($this->faker->unique()->numberBetween(1, 100), 3, '0'),
            'nis' => $this->faker->optional()->numerify('########'),
            'fullname' => $this->faker->name(),
            'username' => $this->faker->unique()->userName(),
            'password' => Hash::make('password'),
            'kelas' => $this->faker->optional()->randomElement(['X IPA 1', 'X IPA 2', 'XII IPS 1']),
            'alamat' => $this->faker->address(),
            'verif' => $this->faker->randomElement(['Terverifikasi', 'Belum Terverifikasi']),
            'role' => $this->faker->randomElement(['admin', 'user']),
            'join_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

