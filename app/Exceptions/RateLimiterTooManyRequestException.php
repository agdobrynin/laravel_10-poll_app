<?php
declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class RateLimiterTooManyRequestException extends TooManyRequestsHttpException
{
    public readonly string $error;

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

        $this->error = 'Too many request.' . ($this->retryAfter ? sprintf(' Retry after %d %s.', $retryAfterValue, $retryAfterTitle) : '');
        parent::__construct($retryAfter);
    }
}
