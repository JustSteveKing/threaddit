<?php

declare(strict_types=1);

namespace App\Observers;

use App\Events\CreatedThread;
use App\Jobs\Threads\ProcessNewThread;
use App\Models\Thread;
use Illuminate\Contracts\Bus\Dispatcher;
use function Illuminate\Support\defer;

final readonly class ThreadObserver
{
    public function __construct(
        private Dispatcher $bus,
    ) {}

    public function created(Thread $thread): void
    {
        broadcast(new CreatedThread(
            thread: $thread,
        ));

        defer(
            callback: fn() => $this->bus->dispatch(
                command: new ProcessNewThread(
                    thread: $thread,
                ),
            ),
            name: 'threads.processing',
        );
    }
}
