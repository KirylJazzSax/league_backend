<?php

declare(strict_types=1);

namespace App\Infrastructure\Redis;

use App\League\Domain\League;
use App\League\Domain\LeagueRepositoryInterface;
use Predis\Client;
use Symfony\Component\Serializer\SerializerInterface;

class RedisLeagueRepository implements LeagueRepositoryInterface
{
    private Client $client;

    public function __construct(RedisConnection $redis, private SerializerInterface $serializer)
    {
        $this->client = $redis->getClient();
    }

    public function getById(string $id): ?League
    {
        $league = $this->client->get($id);
        return $league ? $this->serializer->deserialize($league, League::class, 'json') : null;
    }

    public function update(string $id, League $league): void
    {
        $this->client->set($id, $this->serializer->serialize($league, 'json'));
    }

    public function create(string $id, League $league): void
    {
        $this->client->set($league->getId(), $this->serializer->serialize($league, 'json'));
    }
}
