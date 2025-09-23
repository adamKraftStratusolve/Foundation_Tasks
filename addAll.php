<?php

class AddAll
{
    static function addAllIterative(array $numbers) {

        $total = 0;
        $count = count($numbers);
        foreach ($numbers as $index => $value) {
            $total += $value * ($count - $index);
        }
        return $total;
    }

    static function addAllRecursive(array $numbers, int $index = 0) {

        if ($index >= count($numbers)) {
            return 0;
        }
        $weight = count($numbers) - $index;
        $currentValue = $numbers[$index] * $weight;
        return $currentValue + self::addAllRecursive($numbers, $index + 1);
    }
}

$input = [1, 1, 1, 1, 1];

$iterativeResult = AddAll::addAllIterative($input);
echo "Iterative Result: " . $iterativeResult . "\n";

$recursiveResult = AddAll::addAllRecursive($input);
echo "Recursive Result: " . $recursiveResult . "\n";

