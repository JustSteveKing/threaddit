<?php

declare(strict_types=1);

namespace App\Jobs\Threads;

use App\Models\Thread;
use ArrayObject;
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

    public function handle(): void
    {
        $meta = $this->thread->meta ?? new ArrayObject();
        $urls = [];

        preg_match_all(
            pattern: '#https?://\S+#i',
            subject: $this->thread->body,
            matches: $urls,
        );

        if (empty($urls)) {
            return;
        }

        foreach ($urls as $url) {
            $url = $url[0]; // Get the first match from the array
            $unfurledData = $this->unfurl($url);

            if ( ! empty($unfurledData)) {
                $meta->append(
                    value: [
                        'links' => [
                            'url' => $url,
                            ...$unfurledData,
                        ],
                    ],
                );
            }
        }

        $this->thread->update([
            'meta' => $meta,
        ]);
    }

    private function unfurl(string $url): array
    {
        return get_meta_tags(
            filename: $url,
        );
    }
}
