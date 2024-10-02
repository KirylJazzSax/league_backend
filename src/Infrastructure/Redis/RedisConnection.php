<?php

declare(strict_types=1);

namespace App\Infrastructure\Redis;

use Predis\Client;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class RedisConnection
{
    private Client $client;

    public function __construct(
        #[Autowire(param: 'redis_host')]
        string $host,
        #[Autowire(param: 'redis_port')]
        int $port,
    ) {
        $this->client = new Client([
            'host' => $host,
            'port' => $port,
        ]);
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
