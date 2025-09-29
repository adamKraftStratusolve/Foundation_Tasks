<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Simple logging function
function log_message($message, $data = null) {
    $log_entry = "[API LOG] " . $message;
    if ($data !== null) {
        $log_entry .= ": " . var_export($data, true);
    }
    error_log($log_entry);
}

require_once 'person_repository.php';
require_once 'person_model.php';

$repo = new PersonRepository();

$action = $_REQUEST['action'] ?? 'none';

log_message("Request received", ['method' => $_SERVER['REQUEST_METHOD'], 'action' => $action]);

try {
    switch ($action) {
        case 'create':
            log_message("Executing action: create");
            $data = json_decode(file_get_contents('php://input'));
            log_message("Received data for create", $data);

            if (!$data) {
                http_response_code(400);
                log_message("ERROR: Invalid or empty JSON payload for create.");
                echo json_encode(['error' => 'Invalid or empty JSON payload.']);
                break;
            }

            $person = new Person($data->firstName, $data->surname, $data->dateOfBirth, $data->emailAddress, $data->age);
            $repo->savePerson($person);
            log_message("Successfully executed action: create");
            echo json_encode(['status' => 'success']);
            break;

        // MODIFIED: This block is updated to ensure consistent API responses.
        case 'read':
            log_message("Executing action: read");
            $peopleData = $repo->loadAllPeople(); // Get raw data from the database
            $people = []; // Create a new array to hold Person objects

            // Loop through the raw data and create a standardized Person object for each row
            foreach ($peopleData as $row) {
                $people[] = new Person($row['FirstName'], $row['Surname'], $row['DateOfBirth'], $row['EmailAddress'], $row['Age'], $row['PersonID']);
            }

            log_message("Successfully executed action: read", ["people_found" => count($people)]);
            echo json_encode($people); // Encode the array of Person objects
            break;

        case 'update':
            log_message("Executing action: update");
            $data = json_decode(file_get_contents('php://input'));
            log_message("Received data for update", $data);

            if (!$data || !isset($data->personId)) {
                http_response_code(400);
                log_message("ERROR: Invalid payload or missing personId for update.");
                echo json_encode(['error' => 'Invalid or empty JSON payload, or personId is missing.']);
                break;
            }

            $person = new Person($data->firstName, $data->surname, $data->dateOfBirth, $data->emailAddress, $data->age, $data->personId);
            $repo->updatePerson($person);
            log_message("Successfully executed action: update", ["personId" => $data->personId]);
            echo json_encode(['status' => 'success', 'message' => 'Person updated successfully.']);
            break;

        case 'delete':
            log_message("Executing action: delete");
            $data = json_decode(file_get_contents('php://input'));
            log_message("Received data for delete", $data);

            if (isset($data->personId)) {
                $repo->deletePerson($data->personId);
                log_message("Successfully executed action: delete", ["personId" => $data->personId]);
                echo json_encode(['status' => 'success']);
            } else {
                http_response_code(400);
                log_message("ERROR: personId is missing for delete.");
                echo json_encode(['error' => 'personId is missing.']);
            }
            break;

        case 'find':
            log_message("Executing action: find");
            $firstName = $_GET['firstName'] ?? null;
            $surname = $_GET['surname'] ?? null;
            $dob = $_GET['dateOfBirth'] ?? null;
            $params = ['firstName' => $firstName, 'surname' => $surname, 'dateOfBirth' => $dob];
            log_message("Search parameters for find", $params);

            $person = $repo->loadPerson($firstName, $surname, $dob);
            log_message("Successfully executed action: find", ["person_found" => $person ? "Yes" : "No"]);
            echo json_encode($person);
            break;

        default:
            http_response_code(400);
            log_message("ERROR: Invalid action specified.", ['action' => $action]);
            echo json_encode(['error' => 'Invalid action specified.']);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    log_message("FATAL ERROR: Exception caught", $e->__toString());
    echo json_encode(['error' => 'An internal server error occurred. Check the logs for details.']);
}