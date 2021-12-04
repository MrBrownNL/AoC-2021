<?php

$bingo = new Bingo();
echo "Puzzle 1 result: " . $bingo->playBingo() . PHP_EOL;

echo "Puzzle 2 result: " . $bingo->playBingo(false);


class Bingo {
    private const BINGO_MARKER = 'X';

    private array $bingoNumbers;
    private array $bingoCards;

    public function __construct()
    {
        $lines = file('puzzle_input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $this->bingoNumbers = explode(",", $lines[0]);
        $this->bingoCards = [];
        $this->lastWinningBingoCard = [];

        for ($x=1; $x < count($lines); $x+= 5) {
            $bingoCard = [];
            for($i=0; $i < 5; $i++) {
                $bingoCard[] = preg_split('/\s+/', $lines[$x + $i], -1,PREG_SPLIT_NO_EMPTY);
            }
            $this->bingoCards[] = $bingoCard;
        }
    }

    public function playBingo(bool $getFirstWinningCard = true): int
    {
        $result = 0;
        foreach ($this->bingoNumbers as $number) {
            $this->markNumber($number);

            $bingo = $this->checkBingo();

            if ($bingo) {
                $result = $bingo * $number;

                if ($getFirstWinningCard) {
                    return $result;
                }
            }
        }

        return $result;
    }

    private function markNumber(int $number): void
    {
        foreach ($this->bingoCards as $cardKey => $card) {
            foreach ($card as $rowKey => $row) {
                $index = array_search($number, $row);
                if ($index > -1) {
                    $this->bingoCards[$cardKey][$rowKey][$index] = self::BINGO_MARKER;
                }
            }
        }
    }

    private function checkBingo(): int
    {
        $winningCardSum = 0;

        foreach ($this->bingoCards as $cardKey => $card) {
            if ($this->checkHorizontalBingo($card) || $this->checkVerticalBingo($card)) {
                unset($this->bingoCards[$cardKey]);

                $winningCardSum = $this->getBingoCardSum($card);
            }
        }

        return $winningCardSum;
    }

    private function checkHorizontalBingo(array $card): bool
    {
        foreach ($card as $row) {
            if (count(array_keys($row, self::BINGO_MARKER)) === count($row)) {
                return true;
            }
        }

        return false;
    }

    private function checkVerticalBingo(array $card): bool
    {
        for ($x = 0; $x < count($card[0]); $x++) {
            $markedCount = 0;

            foreach ($card as $row) {
                if ($row[$x] === self::BINGO_MARKER) {
                    $markedCount++;
                }
            }

            if ($markedCount === count($card)) {
                return true;
            }
        }

        return false;
    }

    private function getBingoCardSum(array $card): int
    {
        return array_reduce($card, function($result, $value) {
            return $result + array_sum($value);
        });
    }
}
