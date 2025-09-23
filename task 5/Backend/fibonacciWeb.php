<?php /** @noinspection ALL */

class FibonacciWeb
{
    static function getFibonacciNumber(int $n): int
    {
        if ($n <= 1) {
            return $n;
        }
        return self::getFibonacciNumber($n - 1) + self::getFibonacciNumber($n - 2);
    }
    static function generateFibonacciRecursive(int $limit) {

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
}