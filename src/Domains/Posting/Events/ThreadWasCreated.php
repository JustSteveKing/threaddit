<?php

declare(strict_types=1);

namespace Threaddit\Domains\Posting\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;
use Threaddit\Domains\Posting\DataObjects\NewThread;

final class ThreadWasCreated extends ShouldBeStored
{
    public function __construct(
        public readonly NewThread $thread,
    ) {}
}
