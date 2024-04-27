<?php

namespace App\Enum;

enum DoubleWinningColor: string
{
    case WHITE = 'white';
    case GREEN = 'green';
    case BLACK = 'black';

    public static function getColor(int $case): DoubleWinningColor
    {
        return match ($case) {
            1, 2, 3, 4, 5, 6, 7 => self::GREEN,
            8, 9, 10, 11, 12, 13, 14 => self::BLACK,
            default => self::WHITE
        };
    }

    public static function getNumber(string $color): int
    {
        return match ($color) {
            (self::GREEN)->value => rand(1, 7),
            (self::BLACK)->value => rand(8, 14),
            default => 0
        };
    }
}
