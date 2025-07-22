<?php

declare(strict_types=1);

namespace Threaddit\Domains\Posting\Repositories;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Database\DatabaseManager;
use Threaddit\Domains\Posting\DataObjects\NewReply;
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

    public function replyToThread(NewReply $reply): Reply
    {
        return $this->database->transaction(
            callback: fn() => Reply::query()->create([
                'body' => $reply->body,
                'thread_id' => $reply->thread,
                'user_id' => $reply->user,
            ]),
            attempts: 3,
        );
    }
}
