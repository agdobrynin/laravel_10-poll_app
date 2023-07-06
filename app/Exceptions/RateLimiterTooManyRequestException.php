<?php
declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Support\Str;
use RuntimeException;

class RateLimiterTooManyRequestException extends RuntimeException
{
    public function __construct(
        readonly public ?int $retryAfter = null,
    )
    {
        $retryAfterValue = $this->retryAfter >= 60
            ? ceil($this->retryAfter / 60)
            : $this->retryAfter;

        $retryAfterTitle = $this->retryAfter >= 60
            ? Str::plural('minute', $retryAfterValue)
            : Str::plural('second', $retryAfterValue);

        $message = 'Too many request.' . ($this->retryAfter ? sprintf(' Retry after %d %s.', $retryAfterValue, $retryAfterTitle) : '');

        parent::__construct($message);
    }
}
