<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Threaddit\Domains;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerDomains();
    }

    public function boot(): void
    {
        $this->bootApp();
    }

    private function bootApp(): void
    {
        Model::shouldBeStrict();
        JsonResource::withoutWrapping();
    }

    private function registerDomains(): void
    {
        $this->app->register(
            provider: Domains\Posting\Providers\DomainServiceProvider::class,
        );
    }
}
