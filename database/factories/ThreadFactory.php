<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Modules\Identity\Models\User;
use App\Modules\Posting\Models\Thread;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Thread> */
final class ThreadFactory extends Factory
{
    /** @var class-string<Thread> */
    protected $model = Thread::class;

    /** @return array<string,mixed> */
    public function definition(): array
    {
        return [
            'body' => $this->faker->realText(),
            'meta' => null,
            'reactions' => $this->faker->numberBetween(
                int1: 0,
                int2: 200,
            ),
            'user_id' => User::factory(),
        ];
    }
}
