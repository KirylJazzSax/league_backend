<?php

declare(strict_types=1);

namespace App\Team\Domain;

use App\Team\Enum\ScoreEnum;

class Team
{
    /**
     * @param string $name
     * @param array $scores
     */
    public function __construct(
        private string $name = '',
        private array $scores = [],
    ) {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param ScoreEnum $score
     * @param int $value
     * @return void
     */
    public function addScore(ScoreEnum $score, int $value): void
    {
        $this->scores[$score->value] += $value;
    }

    /**
     * @return array
     */
    public function getScores(): array
    {
        return $this->scores;
    }

    /**
     * @param ScoreEnum $score
     * @param int $value
     * @return void
     */
    public function setScore(ScoreEnum $score, int $value): void
    {
        $this->scores[$score->value] = $value;
    }

    //    public function jsonSerialize(): mixed
    //    {
    //        $result = [
    //            'name' => $this->name,
    //        ];
    //
    //        foreach ($this->scores as $key => $score) {
    //            $result['scores'][$key] = $score;
    //        }
    //
    //        return $result;
    //    }
}
