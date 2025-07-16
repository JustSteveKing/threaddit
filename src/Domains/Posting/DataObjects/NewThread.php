<?php

declare(strict_types=1);

namespace Threaddit\Domains\Posting\DataObjects;

final readonly class NewThread
{
    public function __construct(
        public string $body,
        public string $user,
    ) {}

    /**
     * @return array{body:string,user_id:string}
     */
    public function toArray(): array
    {
        return [
            'body' => $this->body,
            'user_id' => $this->user,
        ];
    }
}
