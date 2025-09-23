<?php

class Fibonacci
{
    static function generateFibonacciIterative(int $limit): array
    {
        if ($limit < 0) {
            return [];
        }
        if ($limit === 0) {
            return [0];
        }

        $sequence = [0, 1];

        while (true) {
            $nextValue = $sequence[count($sequence) - 1] + $sequence[count($sequence) - 2];
            if ($nextValue > $limit) {
                break;
            }
            $sequence[] = $nextValue;
        }

        return $sequence;
    }

    static function generateFibonacciRecursive(int $limit): array
    {
        if ($limit < 0) {
            return [];
        }

        $sequence = [];
        for ($i = 0; ; $i++) {
            $value = self::getFibonacciNumber($i);
            if ($value > $limit) {
                break;
            }
            $sequence[] = $value;
        }
        return $sequence;
    }

    static function getFibonacciNumber(int $n): int
    {
        if ($n <= 1) {
            return $n;
        }
        return self::getFibonacciNumber($n - 1) + self::getFibonacciNumber($n - 2);
    }
}

$limit = 34;

$iterativeResult = Fibonacci::generateFibonacciIterative($limit);
echo "Iterative Fibonacci up to {$limit}: " . implode(", ", $iterativeResult) . "\n";

$recursiveResult = Fibonacci::generateFibonacciRecursive($limit);
echo "Recursive Fibonacci up to {$limit}: " . implode(", ", $recursiveResult) . "\n";
