<?php

declare(strict_types=1);

namespace App\Modules\Posting\Events;

use App\Modules\Posting\Models\Thread;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

final class ThreadWasCreated implements ShouldBroadcast
{
    use SerializesModels;

    public function __construct(
        public readonly Thread $thread,
    ) {}

    public function broadcastAs(): string
    {
        return 'thread.created';
    }

    public function broadcastOn(): Channel
    {
        return new Channel(
            name: 'threads',
        );
    }
}
