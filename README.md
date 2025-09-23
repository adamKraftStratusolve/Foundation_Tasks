## Task 1: Weighted Array Sum

### Description
This utility calculates a weighted sum of an array's elements. The calculation is equivalent to summing the array, removing the first element, and repeating until the array is empty.

The mathematical formula is: `(n * arr[0]) + ((n-1) * arr[1]) + ... + (1 * arr[n-1])`.

### Usage
When the function is called with the array `[1, 1, 1, 1, 1]`, it returns `15`, which is calculated as `(1*5) + (1*4) + (1*3) + (1*2) + (1*1)`.

---

## Task 2: Fibonacci Sequence Generator

### Description
This utility generates the Fibonacci sequence up to a specified limit. The Fibonacci sequence is a series of numbers where each number is the sum of the two preceding ones, starting from 0 and 1.

The repository contains both an efficient iterative implementation and an academic recursive one.

### Usage
When the function is called with a limit of `34`, it produces the sequence: `0, 1, 1, 2, 3, 5, 8, 13, 21, 34`.

---

## Task 3: Palindrome Checker

### Description
This utility checks if a given string is a palindrome. A palindrome is a word or phrase that reads the same forwards and backward.

This implementation is **case-insensitive** and ignores all spaces, punctuation, and other non-alphanumeric characters.

### Usage
The function will return `true` for inputs like "Never Odd Or Even" and "A man, a plan, a canal: Panama". It will return `false` for "hello world".

---

## Task 4: Group Items by Owner

### Description
This utility transforms an associative array mapping items to their owners into a new array where owners are the keys and their corresponding values are a list of items they own.

### Usage
Given an input array of `["Baseball Bat" => "John", "Golf ball" => "Stan", "Tennis Racket" => "John"]`, the function will produce the following structure: `{"John":["Baseball Bat","Tennis Racket"],"Stan":["Golf ball"]}`.