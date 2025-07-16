<?php

declare(strict_types=1);

namespace App\Http\Controllers\Threads;

use App\Http\Requests\Threads\StoreRequest;
use App\Jobs\Threads\CreateNewThread;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

use function Illuminate\Support\defer;

final readonly class StoreController
{
    public function __construct(
        #[CurrentUser]
        private User $user,
        private Dispatcher $bus,
    ) {}

    /**
     * @param StoreRequest $request
     * @return Response
     * @throws Throwable
     */
    public function __invoke(StoreRequest $request): Response
    {
        defer(
            callback: fn() => $this->bus->dispatch(
                command: new CreateNewThread(
                    payload: $request->payload(
                        user: $this->user->id,
                    ),
                ),
            ),
            name: 'create-new-thread',
        );

        return new JsonResponse(
            data: [
                'message' => 'We are processing your request to create a new thread.',
            ],
            status: Response::HTTP_ACCEPTED,
        );
    }
}
