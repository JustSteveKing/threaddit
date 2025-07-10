<?php

declare(strict_types=1);

namespace App\Modules\Posting\Jobs;

use App\Modules\Posting\Models\Thread;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;

final class ProcessNewThread implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly Thread $thread,
    ) {}

    public function handle(): void {}
}
