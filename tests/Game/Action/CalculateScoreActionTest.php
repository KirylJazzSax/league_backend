<?php

declare(strict_types=1);

namespace App\Tests\League\Action;

use App\League\Action\CalculateScoreAction;
use App\League\Domain\League;
use App\League\Domain\LeagueRepositoryInterface;
use App\League\Dto\CalculateScoreActionInputDto;
use App\League\Dto\MatchDto;
use App\League\Dto\TeamDto;
use App\Team\Enum\ScoreEnum;
use App\Team\Factory\TeamFactory;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CalculateScoreActionTest extends TestCase
{

    #[DataProvider('executeDataProvider')]
    public function testExecute(League $game, CalculateScoreActionInputDto $dto, League $expected): void
    {
        $gameRepository = $this->createMock(LeagueRepositoryInterface::class);
        $gameRepository->method('getById')->willReturn($game);

        $action = new CalculateScoreAction($gameRepository);
        $action->execute($dto);

        self::assertEquals($expected, $game);
    }

    public static function executeDataProvider(): iterable
    {
        $game = new League('', TeamFactory::createInitialTeams());
        $expectedLeague = new League('', TeamFactory::createInitialTeams());
        $match = new MatchDto(
            new TeamDto('Liverpool', 2),
            new TeamDto('Chelsea', 1),
        );
        $dto = new CalculateScoreActionInputDto(
            '',
            [$match],
        );

        $expectedLeague->getTeam('Liverpool')->addScore(ScoreEnum::PTS, 3);
        $expectedLeague->getTeam('Liverpool')->addScore(ScoreEnum::W, 1);
        $expectedLeague->getTeam('Liverpool')->addScore(ScoreEnum::P, 1);
        $expectedLeague->getTeam('Liverpool')->addScore(ScoreEnum::GS, 2);
        $expectedLeague->getTeam('Liverpool')->addScore(ScoreEnum::GC, 1);

        $expectedLeague->getTeam('Chelsea')->addScore(ScoreEnum::P, 1);
        $expectedLeague->getTeam('Chelsea')->addScore(ScoreEnum::GS, 1);
        $expectedLeague->getTeam('Chelsea')->addScore(ScoreEnum::GC, 2);
        $expectedLeague->getTeam('Chelsea')->addScore(ScoreEnum::L, 1);

        yield 'First team won' => [
            $game,
            $dto,
            $expectedLeague,
        ];

        $game = new League('', TeamFactory::createInitialTeams());
        $expectedLeague = new League('', TeamFactory::createInitialTeams());
        $match = new MatchDto(
            new TeamDto('Manchester City', 2),
            new TeamDto('Chelsea', 4)
        );
        $dto = new CalculateScoreActionInputDto(
            '',
            [$match],
        );

        $expectedLeague->getTeam('Chelsea')->addScore(ScoreEnum::PTS, 3);
        $expectedLeague->getTeam('Chelsea')->addScore(ScoreEnum::W, 1);
        $expectedLeague->getTeam('Chelsea')->addScore(ScoreEnum::P, 1);
        $expectedLeague->getTeam('Chelsea')->addScore(ScoreEnum::GS, 4);
        $expectedLeague->getTeam('Chelsea')->addScore(ScoreEnum::GC, 2);

        $expectedLeague->getTeam('Manchester City')->addScore(ScoreEnum::P, 1);
        $expectedLeague->getTeam('Manchester City')->addScore(ScoreEnum::GS, 2);
        $expectedLeague->getTeam('Manchester City')->addScore(ScoreEnum::GC, 4);
        $expectedLeague->getTeam('Manchester City')->addScore(ScoreEnum::L, 1);

        yield 'Second team won' => [
            $game,
            $dto,
            $expectedLeague,
        ];


        $game = new League('', TeamFactory::createInitialTeams());
        $expectedLeague = new League('', TeamFactory::createInitialTeams());
        $match = new MatchDto(
            new TeamDto('Arsenal', 0),
            new TeamDto('Liverpool', 0)
        );
        $dto = new CalculateScoreActionInputDto(
            '',
            [$match],
        );

        $expectedLeague->getTeam('Liverpool')->addScore(ScoreEnum::PTS, 1);
        $expectedLeague->getTeam('Liverpool')->addScore(ScoreEnum::P, 1);
        $expectedLeague->getTeam('Liverpool')->addScore(ScoreEnum::D, 1);

        $expectedLeague->getTeam('Arsenal')->addScore(ScoreEnum::PTS, 1);
        $expectedLeague->getTeam('Arsenal')->addScore(ScoreEnum::P, 1);
        $expectedLeague->getTeam('Arsenal')->addScore(ScoreEnum::D, 1);

        yield 'Drawn with zeros' => [
            $game,
            $dto,
            $expectedLeague,
        ];

        $game = new League('', TeamFactory::createInitialTeams());
        $expectedLeague = new League('', TeamFactory::createInitialTeams());
        $match = new MatchDto(
            new TeamDto('Arsenal', 3),
            new TeamDto('Liverpool', 3),
        );
        $dto = new CalculateScoreActionInputDto(
            '',
            [$match],
        );

        $expectedLeague->getTeam('Liverpool')->addScore(ScoreEnum::PTS, 1);
        $expectedLeague->getTeam('Liverpool')->addScore(ScoreEnum::P, 1);
        $expectedLeague->getTeam('Liverpool')->addScore(ScoreEnum::D, 1);
        $expectedLeague->getTeam('Liverpool')->addScore(ScoreEnum::GS, 3);
        $expectedLeague->getTeam('Liverpool')->addScore(ScoreEnum::GC, 3);

        $expectedLeague->getTeam('Arsenal')->addScore(ScoreEnum::PTS, 1);
        $expectedLeague->getTeam('Arsenal')->addScore(ScoreEnum::P, 1);
        $expectedLeague->getTeam('Arsenal')->addScore(ScoreEnum::D, 1);
        $expectedLeague->getTeam('Arsenal')->addScore(ScoreEnum::GS, 3);
        $expectedLeague->getTeam('Arsenal')->addScore(ScoreEnum::GC, 3);

        yield 'Drawn' => [
            $game,
            $dto,
            $expectedLeague,
        ];
    }

    #[DataProvider('exceptionDataProvider')]
    public function testException(?League $game, CalculateScoreActionInputDto $dto, string $exception): void
    {
        self::expectException($exception);
        $gameRepository = $this->createMock(LeagueRepositoryInterface::class);
        $gameRepository->method('getById')->willReturn($game);

        $action = new CalculateScoreAction($gameRepository);
        $action->execute($dto);
    }

    public static function exceptionDataProvider(): iterable
    {
        $match = new MatchDto(
            new TeamDto('Liverpool', 0), new TeamDto('Liverpool', 0),
        );
        yield 'Logic exception' => [
            'game' => new League('', TeamFactory::createInitialTeams()),
            'dto' => new CalculateScoreActionInputDto('', [$match]),
            'exception' => \LogicException::class,
        ];

        $match = new MatchDto(
            new TeamDto('Chelsea', 0), new TeamDto('Liverpool', 0)
        );
        yield 'Invalid argument exception' => [
            'game' => null,
            'dto' => new CalculateScoreActionInputDto('', [$match]),
            'exception' => \InvalidArgumentException::class,
        ];

        $match = new MatchDto(
            new TeamDto('Chelseaa', 0), new TeamDto('Liverpool', 0)
        );
        yield 'Team not set 1' => [
            'game' => null,
            'dto' => new CalculateScoreActionInputDto('', [$match]),
            'exception' => \LogicException::class,
        ];

        $match = new MatchDto(
            new TeamDto('Chelsea', 0), new TeamDto('Liverpooll', 0),
        );
        yield 'Team not set 2' => [
            'game' => null,
            'dto' => new CalculateScoreActionInputDto('', [$match]),
            'exception' => \LogicException::class,
        ];
    }
}
