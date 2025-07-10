<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Modules\Identity\Enums\Status;
use App\Modules\Identity\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/** @extends Factory<User> */
final class UserFactory extends Factory
{
    /** @var class-string<User> */
    protected $model = User::class;

    /** @return array<string,mixed> */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'handle' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'status' => $this->faker->randomElement(array: Status::cases()),
            'bio' => $this->faker->optional()->realText(),
            'email_verified_at' => now(),
        ];
    }
}
