<?php

declare(strict_types=1);

namespace App\Team\Enum;

enum ScoreEnum: string
{
    case PTS = 'PTS';
    case P = 'P';
    case W = 'W';
    case D = 'D';
    case L = 'L';
    // Goal scored
    case GS = 'GS';
    // Goal conceded
    case GC = 'GC';
}
