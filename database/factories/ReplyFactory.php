<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Threaddit\Domains\Posting\Enums\ReplyStatus;

/** @extends Factory<Reply> */
final class ReplyFactory extends Factory
{
    /** @var class-string<Reply> */
    protected $model = Reply::class;

    /** @return array<string,mixed> */
    public function definition(): array
    {
        return [
            'status' => $this->faker->randomElement(array: ReplyStatus::cases()),
            'body' => $this->faker->realText(),
            'meta' => null,
            'thread_id' => Thread::factory(),
            'user_id' => User::factory(),
        ];
    }
}
