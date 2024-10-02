<?php

declare(strict_types=1);

namespace App\League\Action;

use App\League\Domain\League;
use App\League\Domain\LeagueRepositoryInterface;
use App\Team\Factory\TeamFactory;

class CreateAction
{
    /**
     * @param LeagueRepositoryInterface $repository
     */
    public function __construct(private LeagueRepositoryInterface $repository)
    {
    }

    /**
     * @param string $id
     * @return League
     */
    public function execute(string $id): League
    {
        $league = new League($id, TeamFactory::createInitialTeams());
        $this->repository->create($id, $league);

        return $league;
    }
}
