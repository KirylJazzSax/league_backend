<?php

declare(strict_types=1);

namespace App\League\Dto;

readonly class PlayActionResponseDto
{
    /**
     * @param string $id
     */
    public function __construct(
        public string $id,
    ) {
    }
}
