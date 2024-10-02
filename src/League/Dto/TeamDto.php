<?php

declare(strict_types=1);

namespace App\League\Dto;

class TeamDto
{
    /**
     * @param string|null $name
     * @param int|null $score
     */
    public function __construct(
        private ?string $name = null,
        private ?int $score = null,
    ) {

    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int|null
     */
    public function getScore(): ?int
    {
        return $this->score;
    }

    /**
     * @param int $score
     * @return void
     */
    public function setScore(int $score): void
    {
        $this->score = $score;
    }
}
