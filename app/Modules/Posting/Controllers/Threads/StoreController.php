<?php

declare(strict_types=1);

namespace App\Modules\Posting\Controllers\Threads;

use App\Modules\Identity\Models\User;
use App\Modules\Posting\Models\Thread;
use App\Modules\Posting\Requests\Threads\StoreRequest;
use App\Modules\Posting\Resources\ThreadResource;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final readonly class StoreController
{
    public function __construct(
        #[CurrentUser]
        private User $user,
        private DatabaseManager $database,
    ) {}

    public function __invoke(StoreRequest $request): Response
    {
        $thread = $this->database->transaction(
            callback: fn() => $this->user->threads()->create([
                'body' => $request->string('body')->toString(),
            ]),
            attempts: 3,
        );

        return new JsonResponse(
            data: new ThreadResource(
                resource: $thread,
            ),
            status: Response::HTTP_CREATED,
        );
    }
}
