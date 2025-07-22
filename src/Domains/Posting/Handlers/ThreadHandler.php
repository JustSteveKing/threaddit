<?php

declare(strict_types=1);

namespace Threaddit\Domains\Posting\Handlers;

use Spatie\EventSourcing\EventHandlers\Projectors\Projector;
use Threaddit\Domains\Posting\Events\ThreadWasCreated;
use Threaddit\Domains\Posting\Events\ThreadWasReplied;
use Threaddit\Domains\Posting\Events\ThreadWasViewed;
use Threaddit\Domains\Posting\Repositories\ThreadsRepository;
use Throwable;

final class ThreadHandler extends Projector
{
    public function __construct(
        private readonly ThreadsRepository $repository,
    ) {}

    /**
     * @param ThreadWasCreated $event
     * @return void
     * @throws Throwable
     */
    public function onThreadWasCreated(ThreadWasCreated $event): void
    {
        $this->repository->create(
            thread: $event->thread,
        );
    }

    public function onThreadWasViewed(ThreadWasViewed $event): void
    {
        $this->repository->increaseViewCount(
            threadId: $event->thread,
        );
    }

    public function onThreadWasReplied(ThreadWasReplied $event): void
    {
        $this->repository->replyToThread(
            reply: $event->reply,
        );
    }
}
