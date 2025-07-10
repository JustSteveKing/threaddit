<?php

declare(strict_types=1);

namespace App\Modules\Posting\Controllers\Threads;

use App\Modules\Posting\Models\Thread;
use App\Modules\Posting\Resources\ThreadResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

final class IndexController
{
    public function __invoke(Request $request): Response
    {
        $threads = QueryBuilder::for(
            subject: Thread::class,
        )->allowedIncludes(
            includes: ['user'],
        )->allowedFilters(
            filters: [
                AllowedFilter::exact(
                    name: 'handle',
                    internalName: 'user.handle',
                ),
            ],
        )->allowedSorts(
            sorts: [
                'reactions',
                'user_id',

            ],
        )->latest()->simplePaginate();

        return new JsonResponse(
            data: ThreadResource::collection(
                resource: $threads,
            ),
            status: Response::HTTP_OK,
        );
    }
}
