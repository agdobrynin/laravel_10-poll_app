<?php
declare(strict_types=1);

namespace App\Services;

class FlashMessageSuccess
{
    public const FLASH_SUCCESS_MESSAGE_KEY = 'success_message';

    public function add(string $message): void
    {
        session()->flash(self::FLASH_SUCCESS_MESSAGE_KEY, $message);
    }

    public function get(): ?string
    {
        return session(self::FLASH_SUCCESS_MESSAGE_KEY);
    }
}
