<?php

declare(strict_types=1);

namespace App\League\Dto;

class MatchDto
{
    /**
     * @param TeamDto|null $firstTeam
     * @param TeamDto|null $secondTeam
     */
    public function __construct(
        private ?TeamDto $firstTeam = null,
        private ?TeamDto $secondTeam = null,
    ) {
    }

    /**
     * @return TeamDto|null
     */
    public function getFirstTeam(): ?TeamDto
    {
        return $this->firstTeam;
    }

    /**
     * @param TeamDto $firstTeam
     * @return void
     */
    public function setFirstTeam(TeamDto $firstTeam): void
    {
        $this->firstTeam = $firstTeam;
    }

    /**
     * @return TeamDto|null
     */
    public function getSecondTeam(): ?TeamDto
    {
        return $this->secondTeam;
    }

    /**
     * @param TeamDto $secondTeam
     * @return void
     */
    public function setSecondTeam(TeamDto $secondTeam): void
    {
        $this->secondTeam = $secondTeam;
    }
}
