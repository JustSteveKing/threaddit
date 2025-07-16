<?php

declare(strict_types=1);

namespace Threaddit\Domains\Posting\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

final class ThreadWasViewed extends ShouldBeStored
{
    public function __construct(
        public readonly string $thread,
        public readonly string $user,
    ) {}
}
