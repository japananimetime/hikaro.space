<?php

namespace App\Repositories;
use Illuminate\Support\Facades\Redis;

class MessageRepo
{
    private $driver;

    public function __construct(Redis $driver)
    {
        $this->driver = $driver;
    }

    public function save(int $shatId, int $messageId, string $text = 'noText'): void
    {
        Redis::hset($shatId, $messageId, $text);
    }

    public function check(int $shatId, int $messageId): bool
    {
        return Redis::hexists($shatId, $messageId);
    }
}