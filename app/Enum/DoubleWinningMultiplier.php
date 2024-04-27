<?php

namespace App\Enum;

enum DoubleWinningMultiplier: int
{
    case WHITE = 14;
    case DOUBLE = 2;

    public static function getMultiplier(string $color): DoubleWinningMultiplier
    {
        return match (strtoupper($color)) {
            'GREEN', 'BLACK' => self::DOUBLE,
            default => self::WHITE
        };
    }
}
