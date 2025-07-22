<?php

declare(strict_types=1);

namespace App\Http\Controllers\Replies;

use App\Http\Requests\Replies\StoreRequest;
use App\Jobs\Threads\ReplyToThread;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use function Illuminate\Support\defer;

final readonly class StoreController
{
    public function __construct(
        #[CurrentUser]
        private User $user,
        private Dispatcher $bus,
    ) {}

    public function __invoke(StoreRequest $request, Thread $thread): Response
    {
        defer(
            callback: fn() => $this->bus->dispatch(
                command: new ReplyToThread(
                    payload: $request->payload(
                        thread: $thread->id,
                        user: $this->user->id,
                    ),
                ),
            ),
            name: 'reply-to-thread',
        );

        return new JsonResponse(
            data: [
                'message' => 'Reply is being processed.',
            ],
            status: Response::HTTP_ACCEPTED,
        );
    }
}
