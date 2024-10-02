<?php

declare(strict_types=1);

namespace App\Team\Factory;

use App\Team\Domain\Team;
use App\Team\Enum\ScoreEnum;

class TeamFactory
{
    /**
     * @return Team[]
     */
    public static function createInitialTeams(): array
    {
        $teams = [
            'Chelsea' => new Team('Chelsea', []),
            'Arsenal' => new Team('Arsenal', []),
            'Manchester City' => new Team('Manchester City', []),
            'Liverpool' => new Team('Liverpool', []),
        ];

        foreach ($teams as $team) {
            foreach (ScoreEnum::cases() as $score) {
                $team->setScore($score, 0);
            }
        }

        return $teams;
    }
}
