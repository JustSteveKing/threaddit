<?php

declare(strict_types=1);

namespace Threaddit\Domains\Posting\DataObjects;

final readonly class NewReply
{
    public function __construct(
        public string $thread,
        public string $user,
        public string $body,
    ) {}
}
