<?php

declare(strict_types=1);

namespace App\League\Dto;

class CalculateScoreActionInputDto
{
    /**
     * @param string|null $id
     * @param array|null $matches
     * @param bool|null $dryRun
     * @param int|null $week
     */
    public function __construct(
        private ?string  $id = null,
        private ?array $matches = null,
        private ?bool $dryRun = null,
        private ?int $week = null,
    ) {
    }

    /**
     * @return array|null
     */
    public function getMatches(): ?array
    {
        return $this->matches;
    }

    /**
     * @param array|null $matches
     * @return void
     */
    public function setMatches(?array $matches): void
    {
        $this->matches = $matches;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return void
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return bool|null
     */
    public function isDryRun(): ?bool
    {
        return $this->dryRun;
    }

    /**
     * @param bool $dryRun
     * @return void
     */
    public function setDryRun(bool $dryRun): void
    {
        $this->dryRun = $dryRun;
    }

    /**
     * @return int|null
     */
    public function getWeek(): ?int
    {
        return $this->week;
    }

    /**
     * @param int|null $week
     * @return void
     */
    public function setWeek(?int $week): void
    {
        $this->week = $week;
    }
}
