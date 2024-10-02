<?php

declare(strict_types=1);

namespace App\Team\Enum;

enum PointsEnum
{
    case WON;
    case DRAWN;
    case LOSS;

    public function score(): int
    {
        return match ($this) {
            PointsEnum::WON => 3,
            PointsEnum::DRAWN => 1,
            PointsEnum::LOSS => 0,
        };
    }
}
