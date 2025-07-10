<?php

declare(strict_types=1);

namespace App\Modules\Posting\Observers;

use App\Modules\Posting\Events\ThreadWasCreated;
use App\Modules\Posting\Jobs\ProcessNewThread;
use App\Modules\Posting\Models\Thread;
use Illuminate\Contracts\Bus\Dispatcher;

use function Illuminate\Support\defer;

final readonly class ThreadObserver
{
    public function __construct(
        private Dispatcher $bus,
    ) {}

    public function created(Thread $thread): void
    {
        broadcast(new ThreadWasCreated(
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
