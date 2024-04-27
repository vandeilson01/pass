<?php

namespace App\Services\Games\Double;

use App\Enum\DoubleWinningColor;
use App\Models\SettingsDouble;

class CalculateMultiplierService
{
    public function multiplier(): float|int
    {
        $winning_number = rand(0, 14);

        $settingsDouble = SettingsDouble::first();

        if(!$settingsDouble){
            return $winning_number;
        }

        if(!is_null($settingsDouble->next_double_value)){
            $winning_number = $settingsDouble->next_double_value;

            $settingsDouble->update([
                'next_double_value' => null,
            ]);
        }

        if(!is_null($settingsDouble->next_double_color)){
            $winning_number = DoubleWinningColor::getNumber($settingsDouble->next_double_color);

            $settingsDouble->update([
                'next_double_color' => null,
            ]);
        }

        return $winning_number;
    }

}
