<?php

declare(strict_types=1);

namespace Threaddit\Domains\Posting\Queries;

use App\Models\Thread;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class ThreadQuery
{
    public function handle(Builder|string|null $query = null): Builder
    {
        return QueryBuilder::for(
            subject: $query ?? Thread::query(),
        )->allowedIncludes(
            includes: ['user', 'replies'],
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
        )->getEloquentBuilder();
    }
}
