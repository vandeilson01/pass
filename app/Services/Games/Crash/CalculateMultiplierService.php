<?php

namespace App\Services\Games\Crash;

use App\Models\SettingsCrash;

class CalculateMultiplierService
{

    public function multiplier(): float
    {
        $settings = SettingsCrash::first();
        $next_crash = $settings->next_crash_value;

        if ($next_crash) {
            $value = $next_crash;

            $settings->next_crash_value = null;
            $settings->save();
        } else {
            $rand = rand(0, 99);

            $crash = match (true) {
                $rand <= 40 => rand(0, 1),
                $rand > 40 && $rand <= 70 => rand(1, 3),
                $rand > 70 && $rand <= 85 => rand(3, 4),
                $rand > 85 && $rand <= 96 => rand(4, 10),
                $rand > 96 => rand(10, 70),
            };

            $decimal = rand(0, 99);
            $decimal = $decimal < 10 ? '0' . $decimal : $decimal;

            $value = $crash . '.' . $decimal;

            if($value < 1){
                $value = (float) rand(0, 2).'.'.rand(0, 99);
            }

        }

        return max($value, 1.03);
    }

}
