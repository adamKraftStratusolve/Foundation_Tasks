<?php

class Palindrome
{
    static function isPalindrome(string $str): bool
    {
        $processedString = preg_replace('/[^a-z0-9]/i', '', strtolower($str));
        return $processedString === strrev($processedString);
    }
}

$isPal = Palindrome::isPalindrome('Never Odd Or Even');

echo $isPal ? 'true' : 'false';

