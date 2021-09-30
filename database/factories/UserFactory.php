<?php

declare(strict_types=1);

namespace Database\Factories;

use ARKEcosystem\Foundation\Fortify\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

final class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'              => $this->faker->firstName,
            'email'             => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'last_login_at'     => null,
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'timezone'          => 'UTC',
            'remember_token'    => Str::random(10),
        ];
    }

    /**
     * Indicate that the user has suername.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withUsername()
    {
        return $this->state(fn () => [
            'username' => $this->faker->unique()->userName,
        ]);
    }
}
