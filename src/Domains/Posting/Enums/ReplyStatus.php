<?php

declare(strict_types=1);

namespace Threaddit\Domains\Posting\Enums;

enum ReplyStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Deleted = 'deleted';
}
