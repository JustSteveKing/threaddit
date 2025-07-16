<?php

declare(strict_types=1);

namespace App\Http\Controllers\Threads;

use App\Http\Resources\ThreadResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Threaddit\Domains\Posting\Queries\ThreadQuery;

final readonly class IndexController
{
    public function __construct(
        private ThreadQuery $query,
    ) {}

    public function __invoke(Request $request): Response
    {
        return new JsonResponse(
            data: ThreadResource::collection(
                resource: $this->query->handle()->latest()->simplePaginate(),
            ),
            status: Response::HTTP_OK,
        );
    }
}
