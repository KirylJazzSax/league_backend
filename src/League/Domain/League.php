<?php

declare(strict_types=1);

namespace App\League\Domain;

use App\Team\Domain\Team;

class League
{
    /**
     * we have only 4 teams, so I think it's alright to keep it within Game
     *
     * @param string $id
     * @param Team[] $teams
     */
    public function __construct(
        private string $id = '',
        private array $teams = [],
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return Team[]
     */
    public function getTeams(): array
    {
        return $this->teams;
    }

    public function getTeam(string $name): ?Team
    {
        $team = $this->teams[$name] ?? null;
        if (is_array($team)) {
            return new Team($team['name'], $team['scores']);
        }

        return $team;
    }

    public function setTeams(array $teams): void
    {
        foreach ($teams as $team) {
            $this->teams[$team->getName()] = $team;
        }
    }
}
