<?php

$crabs = new Crabs();
echo "Puzzle 1 result: " . $crabs->getLowestFuelPrice() . PHP_EOL;

echo "Puzzle 2 result: " . $crabs->getLowestFuelPrice(true) . PHP_EOL;


class Crabs {
    private array $submarines;

    public function __construct()
    {
        $input = file('puzzle_input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $this->submarines = array_map('intval', explode(',', $input[0]));
    }

    public function getLowestFuelPrice(bool $range = false): int
    {
        $max = array_reduce($this->submarines, function ($a, $b) {
            return $a > $b ? $a : $b;
        });

        $fuelPrices = [];
        for ($x = 0; $x <= $max; $x++) {
            $submarineFuel = array_reduce($this->submarines, function($a, $b) use ($x, $range) {
                $diff = abs($x - $b);
                if ($range) {
                    $fuelPrice = $diff > 0 ? array_sum(range(1, $diff)) : 0;
                } else {
                    $fuelPrice = $diff;
                }

                return $a + $fuelPrice;
            });

            $fuelPrices[] = $submarineFuel;
        }

        $fuelPrices = array_unique($fuelPrices);
        asort($fuelPrices);
        $fuelPrices = array_values($fuelPrices);

        return $fuelPrices[0];
    }
}
