<?php

namespace App\Contracts;

use App\Exceptions\RateLimiterTooManyRequestException;

interface RateLimiterInterface
{
    /**
     * @throws RateLimiterTooManyRequestException
     */
    public function limit(int $maxAttempts, int $decaySecond, string $key): void;
}
