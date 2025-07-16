<?php

declare(strict_types=1);

namespace App\Http\Controllers\Threads;

use App\Http\Resources\ThreadResource;
use App\Models\Thread;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function Illuminate\Support\defer;

use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Threaddit\Domains\Posting\Aggregates\ThreadAggregate;
use Threaddit\Domains\Posting\Queries\ThreadQuery;

final readonly class ShowController
{
    public function __construct(
        private ThreadQuery $query,
    ) {}

    public function __invoke(Request $request, string $ulid): Response
    {
        /** @var Thread $thread */
        $thread = $this->query->handle()->findOrFail(
            id: $ulid,
        );

        defer(
            callback: fn() => ThreadAggregate::retrieve(
                uuid: Str::uuid7()->toString(),
            )->viewThread(
                thread: $thread->id,
                user: $request->user()?->id ?? 'guest',
            )->persist(),
        );

        return new JsonResponse(
            data: new ThreadResource(
                resource: $thread,
            ),
            status: Response::HTTP_OK,
        );
    }
}
