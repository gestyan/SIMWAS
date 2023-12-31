<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
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
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'nip' => '19'.fake()->regexify('[7-9]{1}[0-9]{15}'),
            'pangkat' => fake()->randomElement(['IV/a', 'IV/b', 'IV/c', 'IV/d', 'IV/e']),
            'unit_kerja' => fake()->randomElement(['8000', '8010', '8100', '8200', '8300']),
            'jabatan' => fake()->randomElement([
            '21',
            '22',
            '23',
            '24',
            '25',
            '26',
            '27',
            '31',
            '32',
            '33',
            '41',
            '42',
            '43',
            '51',
            '52',
            '53',
            '61',
            '62',
            '63',
            '71',
            '72',
            '73',
            '81',
            '82',
            '83',
            '91',
            '90',
            ]),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
