<?php
declare(strict_types=1);

namespace App\Services;

use App\Contracts\RateLimiterInterface;
use App\Exceptions\RateLimiterTooManyRequestException;
use Illuminate\Cache\RateLimiter as Limiter;
use Illuminate\Http\Request;

readonly class RateLimiter implements RateLimiterInterface
{
    public function __construct(
        private Limiter $rateLimiter,
        private Request $request
    )
    {
    }

    public function limit(int $maxAttempts, int $decaySecond, string $key): void
    {
        $keyFull = $key . '_' . ($this->request->user()?->id ?: $this->request->ip());

        if ($this->rateLimiter->tooManyAttempts($keyFull, $maxAttempts)) {
            throw new RateLimiterTooManyRequestException($this->rateLimiter->availableIn($keyFull));
        }

        $this->rateLimiter->hit($keyFull, $decaySecond);
    }
}
