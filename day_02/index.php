<?php

$lines = explode(PHP_EOL, file_get_contents('puzzle_input.txt'));

$commands = array_map(fn($value) =>  explode(" ", $value), $lines);

$x = 0;
$y = 0;

array_map(function($command) use (&$x, &$y) {
    switch($command[0]) {
        case 'up':
            $y -= $command[1];
            break;
        case 'down':
            $y += $command[1];
            break;
        case 'forward':
            $x += $command[1];
            break;
    }
}, $commands);

echo "Puzzle 1 result: " . $x * $y;

$x = 0;
$y = 0;
$a = 0;

array_map(function($command) use (&$x, &$y, &$a) {
    switch($command[0]) {
        case 'up':
            $a -= $command[1];
            break;
        case 'down':
            $a += $command[1];
            break;
        case 'forward':
            $x += $command[1];
            $y += $a * $command[1];
            break;
    }
}, $commands);

echo PHP_EOL . "Puzzle 2 result: " . $x * $y;
