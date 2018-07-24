<?php

namespace App\Repositories;
use Redis;

class MessageRepo
{
    private $driver;

    public function __construct(Redis $driver)
    {
        $this->driver = $driver;
    }

    public function save(int $shatId, int $messageId, string $text = 'noText'): void
    {
        $this->driver->hset($shatId, $messageId, $text);
    }

    public function check(int $shatId, int $messageId): bool
    {
        return $this->driver->hexists($shatId, $messageId);
    }
}