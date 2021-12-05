<?php

$vents = new Vents(true);
echo "Puzzle 1 result: " . $vents->getDangerousPointCount(2) . PHP_EOL;

$vents2 = new Vents(false);
echo "Puzzle 2 result: " . $vents2->getDangerousPointCount(2) . PHP_EOL;


class Vents {
    private array $ventLines;
    private array $dangerousPoints;

    public function __construct(bool $skipDiagonalLines)
    {
        $lines = file('puzzle_input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        $this->ventLines = array_map(function($line) {
            return preg_split('/,| -> /', $line);
        }, $lines);

        $maxPointValue = $this->getMaxPointValue();

        $row = [];
        for($x = 0; $x <= $maxPointValue; $x++) {
            $row[] = 0;
        }

        $this->dangerousPoints = [];
        for($x = 0; $x <= $maxPointValue; $x++) {
            $this->dangerousPoints[] = $row;
        }

        $this->setDangerousPoints($skipDiagonalLines);
    }

    public function getDangerousPointCount(int $dangerLevel): int
    {
        $dangerousPointCount = 0;
        foreach ($this->dangerousPoints as $line) {
            $dangerousPointCount += count(array_filter($line, function($value) use ($dangerLevel) {
                return $value >= $dangerLevel;
            }));
        }

        return $dangerousPointCount;
    }

    private function setDangerousPoints(bool $skipDiagonalLines): void
    {
        foreach ($this->ventLines as $line) {
            if ($skipDiagonalLines && $line[0] !== $line[2] && $line[1] !== $line[3]) {
                continue;
            }

            $fromX = $line[0];
            $fromY = $line[1];
            $toX = $line[2];
            $toY = $line[3];

            while ($fromX != $toX || $fromY != $toY) {
                $this->dangerousPoints[$fromX][$fromY]++;

                if ($fromX < $toX) {
                    $fromX++;
                } elseif ($fromX > $toX) {
                    $fromX--;
                }
                if ($fromY < $toY) {
                    $fromY++;
                } elseif ($fromY > $toY) {
                    $fromY--;
                }
            }

            $this->dangerousPoints[$fromX][$fromY]++;
        }
    }

    private function getMaxPointValue()
    {
        $maxValue = 0;
        foreach ($this->ventLines as $ventLine) {
            $max = array_reduce($ventLine, function ($a, $b) {
                return $a > $b ? $a : $b;
            });

            $maxValue = $max > $maxValue ? $max : $maxValue;
        }

        return $maxValue;
    }
}
