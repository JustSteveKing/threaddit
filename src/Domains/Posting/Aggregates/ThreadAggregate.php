<?php

declare(strict_types=1);

namespace Threaddit\Domains\Posting\Aggregates;

use Spatie\EventSourcing\AggregateRoots\AggregateRoot;
use Threaddit\Domains\Posting\DataObjects\NewReply;
use Threaddit\Domains\Posting\DataObjects\NewThread;
use Threaddit\Domains\Posting\Events\ThreadWasCreated;
use Threaddit\Domains\Posting\Events\ThreadWasReplied;
use Threaddit\Domains\Posting\Events\ThreadWasViewed;

final class ThreadAggregate extends AggregateRoot
{
    public function createThread(NewThread $thread): ThreadAggregate
    {
        $this->recordThat(
            domainEvent: new ThreadWasCreated(
                thread: $thread,
            ),
        );

        return $this;
    }

    public function viewThread(string $thread, string $user): ThreadAggregate
    {
        $this->recordThat(
            domainEvent: new ThreadWasViewed(
                thread: $thread,
                user: $user,
            ),
        );

        return $this;
    }

    public function replyToThread(NewReply $reply): ThreadAggregate
    {
        $this->recordThat(
            domainEvent: new ThreadWasReplied(
                reply: $reply,
            ),
        );

        return $this;
    }
}
