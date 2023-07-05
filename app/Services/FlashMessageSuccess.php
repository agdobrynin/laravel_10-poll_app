<?php
declare(strict_types=1);

namespace App\Services;

class FlashMessageSuccess
{
    public const FLASH_SUCCESS_MESSAGE_KEY = 'success_message';
    public const FLASH_DANGER_MESSAGE_KEY = 'danger_message';

    public function addSuccess(string $message): void
    {
        session()->flash(self::FLASH_SUCCESS_MESSAGE_KEY, $message);
    }

    public function addDanger(string $message): void
    {
        session()->flash(self::FLASH_DANGER_MESSAGE_KEY, $message);
    }

    public function getSuccess(): ?string
    {
        return session(self::FLASH_SUCCESS_MESSAGE_KEY);
    }

    public function getDanger(): ?string
    {
        return session(self::FLASH_DANGER_MESSAGE_KEY);
    }
}
