<?php

declare(strict_types=1);

namespace Threaddit\Domains\Posting\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\EventSourcing\Facades\Projectionist;
use Threaddit\Domains\Posting\Handlers\ThreadHandler;

final class DomainServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Projectionist::addProjector(
            ThreadHandler::class,
        );
    }
}
