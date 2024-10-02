<?php

declare(strict_types=1);

namespace App\League\Action;

use App\League\Domain\League;
use App\League\Domain\LeagueRepositoryInterface;
use App\League\Dto\CalculateScoreActionInputDto;
use App\League\Dto\MatchDto;
use App\Team\Domain\Team;
use App\Team\Enum\PointsEnum;
use App\Team\Enum\ScoreEnum;

class CalculateScoreAction
{
    /**
     * @param LeagueRepositoryInterface $repository
     */
    public function __construct(private LeagueRepositoryInterface $repository)
    {
    }

    /**
     * @param CalculateScoreActionInputDto $dto
     * @return League
     */
    public function execute(CalculateScoreActionInputDto $dto): League
    {
        $league = $this->repository->getById($dto->getId());

        if (!$league instanceof League) {
            throw new \InvalidArgumentException('There is no league to play.');
        }

        foreach ($dto->getMatches() as $match) {
            $first = $league->getTeam($match->getFirstTeam()->getName());
            $second = $league->getTeam($match->getSecondTeam()->getName());

            $this->guardInput($first, $second);

            $this->calculateScore($first, $second, $league, $match);
        }

        if (!$dto->isDryRun()) {
            $this->repository->update($dto->getId(), $league);
        }

        return $league;
    }

    /**
     * @param Team|null $first
     * @param Team|null $second
     * @return void
     */
    private function guardInput(?Team $first, ?Team $second): void
    {
        if ($first === $second) {
            throw new \LogicException('First team should not equal to second team.');
        }

        if (!$first instanceof Team || !$second instanceof Team) {
            throw new \InvalidArgumentException('Teams must be set');
        }
    }

    /**
     * @param Team $first
     * @param Team $second
     * @param League $league
     * @param MatchDto $dto
     * @return void
     */
    private function calculateScore(Team $first, Team $second, League $league, MatchDto $dto): void
    {
        if ($dto->getFirstTeam()->getScore() > $dto->getSecondTeam()->getScore()) {
            $first->addScore(ScoreEnum::PTS, PointsEnum::WON->score());
            $first->addScore(ScoreEnum::W, 1);
            $second->addScore(ScoreEnum::L, 1);
        }

        if ($dto->getSecondTeam()->getScore() > $dto->getFirstTeam()->getScore()) {
            $second->addScore(ScoreEnum::PTS, PointsEnum::WON->score());
            $second->addScore(ScoreEnum::W, 1);
            $first->addScore(ScoreEnum::L, 1);
        }

        if ($dto->getSecondTeam()->getScore() === $dto->getFirstTeam()->getScore()) {
            $first->addScore(ScoreEnum::D, 1);
            $second->addScore(ScoreEnum::D, 1);
            $first->addScore(ScoreEnum::PTS, PointsEnum::DRAWN->score());
            $second->addScore(ScoreEnum::PTS, PointsEnum::DRAWN->score());
        }

        $first->addScore(ScoreEnum::GS, $dto->getFirstTeam()->getScore());
        $first->addScore(ScoreEnum::GC, $dto->getSecondTeam()->getScore());
        $second->addScore(ScoreEnum::GS, $dto->getSecondTeam()->getScore());
        $second->addScore(ScoreEnum::GC, $dto->getFirstTeam()->getScore());

        $first->addScore(ScoreEnum::P, 1);
        $second->addScore(ScoreEnum::P, 1);

        $league->setTeams([$first, $second]);
    }
}
