<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['number'])) {

    $userInput = $_POST['number'];

    if (is_numeric($userInput)) {

        $limit = (int)$userInput;

        $fibonacciSequence = FibonacciWeb::generateFibonacciRecursive($limit);

        if (!empty($fibonacciSequence)) {
            $resultString = implode(', ', $fibonacciSequence);
            $response = "Fibonacci sequence up to {$limit}: <strong>{$resultString}</strong>";
        } else {
            $response = "No Fibonacci numbers are less than or equal to {$limit}.";
        }

        echo $response;

    } else {
        echo "Error: Please enter a valid number.";
    }

} else {
    echo "Error: Invalid request.";
}