<?php

declare(strict_types=1);

namespace Threaddit\Domains\Posting\Repositories;

use App\Models\Thread;
use Illuminate\Database\DatabaseManager;
use Threaddit\Domains\Posting\DataObjects\NewThread;
use Throwable;

final readonly class ThreadsRepository
{
    public function __construct(
        private DatabaseManager $database,
    ) {}

    /**
     * @param NewThread $thread
     * @return Thread
     * @throws Throwable
     */
    public function create(NewThread $thread): Thread
    {
        return $this->database->transaction(
            callback: fn() => Thread::query()->create($thread->toArray()),
            attempts: 3,
        );
    }

    public function increaseViewCount(string $threadId): int
    {
        return $this->database->transaction(
            callback: fn() => Thread::query()->where(
                column: 'id',
                operator: '=',
                value: $threadId,
            )->increment(
                column: 'views',
            ),
            attempts: 3,
        );
    }
}
