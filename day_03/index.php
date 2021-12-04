<?php

$lines = file('puzzle_input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

echo "Puzzle 1 result: " . puzzle1($lines) . PHP_EOL;

echo "Puzzle 2 result: " . puzzle2($lines);

function puzzle1($lines) {
    $binary = "";
    $i = strlen($lines[0]);

    for ($x=0; $x < $i; $x++) {
        $tmp = [];

        foreach ($lines as $line) {
            $tmp[] = substr($line, $x, 1);
        }

        $binary .= count(array_filter($tmp)) > count($tmp) / 2 ? "1" : "0";
    }

    $gamma = bindec($binary);
    $epsilon = bindec(substr(decbin(~$gamma), -strlen($binary)));

    return $gamma * $epsilon;
}

function puzzle2($lines) {
    return getRating($lines, true) * getRating($lines, false);
}

function getRating($lines, $mostCommonValue, $index = 0)
{
    if (count($lines) === 1) {
        return bindec($lines[0]);
    }

    $tmp = [];
    foreach ($lines as $line) {
        $tmp[] = substr($line, $index, 1);
    }

    $commonValue = count(array_filter($tmp)) >= count($tmp) / 2 ? ($mostCommonValue ? "1" : "0") : ($mostCommonValue ? "0" : "1");

    $newLines = [];
    foreach ($lines as $line) {
        if (substr($line, $index, 1) === $commonValue) {
            $newLines[] = $line;
        }
    }

    return getRating($newLines, $mostCommonValue, $index + 1);
}
