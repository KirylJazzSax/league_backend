<?php

declare(strict_types=1);

namespace App\League\Domain;

interface LeagueRepositoryInterface
{
    /**
     * @param string $id
     * @return League|null
     */
    public function getById(string $id): ?League;

    /**
     * @param string $id
     * @param League $league
     * @return void
     */
    public function update(string $id, League $league): void;

    /**
     * @param string $id
     * @param League $league
     * @return void
     */
    public function create(string $id, League $league): void;
}
