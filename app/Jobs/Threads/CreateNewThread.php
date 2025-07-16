<?php

declare(strict_types=1);

namespace App\Jobs\Threads;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Str;
use Threaddit\Domains\Posting\Aggregates\ThreadAggregate;
use Threaddit\Domains\Posting\DataObjects\NewThread;

final class CreateNewThread implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly NewThread $payload,
    ) {}

    public function handle(): void
    {
        ThreadAggregate::retrieve(
            uuid: Str::uuid7()->toString(),
        )->createThread(
            thread: $this->payload,
        )->persist();
    }
}
