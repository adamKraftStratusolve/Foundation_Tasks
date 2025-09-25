<?php
require_once('person_repository.php');
require_once('data_file.php');
require_once('script_logger.php');

$logger = new ScriptLogger('application.log');
$logger->start();

echo (new PersonRepository)->deleteAllPeople();

if (!empty($peopleData)) {

    echo "Data found. Processing " . count($peopleData) . " people...\n";

    foreach ($peopleData as $personData) {
        $personObject = new Person(
            $personData['firstName'],
            $personData['surname'],
            $personData['dateOfBirth'],
            $personData['emailAddress'],
            isset($personData['age']) ? (int) $personData['age'] : null,
            isset($personData['personId']) ? (int) $personData['personId'] : null
        );
        (new PersonRepository)->savePerson($personObject);
    }
} else {

    echo "No people data to process. ✅\n";
}

$people_array = (new PersonRepository)->loadALlPeople();

foreach ($people_array as $person) {

    echo "ID: " . ($person['PersonID'] ?? 'N/A') .
        ", Name: " . ($person['FirstName'] ?? '') . " " . ($person['Surname'] ?? '') .
        ", Age: " . ($person['Age'] ?? 'N/A') .
        ", Email: " . ($person['EmailAddress'] ?? 'Not Provided') .
        ", DOB: " . ($person['DateOfBirth'] ?? 'Not Provided') . "\n";
}

$logger->end();
echo "Application has finished execution.";
