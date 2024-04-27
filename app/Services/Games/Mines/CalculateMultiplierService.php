<?php

namespace App\Services\Games\Mines;

class CalculateMultiplierService
{
    public function __construct(
        public int $number_of_bombs,
        public int $clicks
    )
    {

    }

    public function multiplier(): float|int
    {
        $multiplier = 0.9334; //Fator Blazer
        $number_of_bombs = $this->number_of_bombs;
        $clicks = $this->clicks;

        if($number_of_bombs + $this->clicks > 25){
            $clicks = 25 - $number_of_bombs;
        }

        if($clicks == 0){
            return number_format(1, 2, '.', '');
        }

        $fator = $multiplier * ($this->combination(25) / $this->combination(25 - $number_of_bombs));

        if($fator < 1) {
            $fator = 1;
        }

        return number_format($fator, 2, '.', '');
    }


    private function combination($number): float
    {
        $clicks = $this->clicks;
        $number_of_bombs = $this->number_of_bombs;

        if($number_of_bombs + $this->clicks > 25){
            $clicks = 25 - $number_of_bombs;
        }

        if($number == $clicks){
            return 1;
        }

        return $this->factorial($number) / ($this->factorial($clicks) * $this->factorial($number - $clicks));
    }

    private function factorial($number): float
    {
        if($number == 0){
            return 1;
        }

        return $number * $this->factorial($number - 1);
    }
}
