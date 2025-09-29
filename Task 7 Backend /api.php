<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}



require_once 'person_repository.php';
require_once 'person_model.php';

$repo = new PersonRepository();

$action = $_REQUEST['action'] ?? 'none';

try {
    switch ($action) {
        case 'create':
            $data = json_decode(file_get_contents('php://input'));

            if (!$data) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid or empty JSON payload.']);
                break;
            }

            $person = new Person($data->firstName, $data->surname, $data->dateOfBirth, $data->emailAddress, $data->age);
            $repo->savePerson($person);
            echo json_encode(['status' => 'success']);
            break;

        case 'read':
            $peopleData = $repo->loadAllPeople();
            $people = [];

            foreach ($peopleData as $row) {
                $people[] = new Person($row['FirstName'], $row['Surname'], $row['DateOfBirth'], $row['EmailAddress'], $row['Age'], $row['PersonID']);
            }

            echo json_encode($people);
            break;

        case 'update':
            $data = json_decode(file_get_contents('php://input'));

            if (!$data || !isset($data->personId)) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid or empty JSON payload, or personId is missing.']);
                break;
            }

            $person = new Person($data->firstName, $data->surname, $data->dateOfBirth, $data->emailAddress, $data->age, $data->personId);
            $repo->updatePerson($person);
            echo json_encode(['status' => 'success', 'message' => 'Person updated successfully.']);
            break;

        case 'delete':
            $data = json_decode(file_get_contents('php://input'));

            if (isset($data->personId)) {
                $repo->deletePerson($data->personId);
                echo json_encode(['status' => 'success']);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'personId is missing.']);
            }
            break;

        case 'find':
            $firstName = $_GET['firstName'] ?? null;
            $surname = $_GET['surname'] ?? null;
            $dob = $_GET['dateOfBirth'] ?? null;
            $params = ['firstName' => $firstName, 'surname' => $surname, 'dateOfBirth' => $dob];

            $person = $repo->loadPerson($firstName, $surname, $dob);
            echo json_encode($person);
            break;

        default:
            http_response_code(400);
            echo json_encode(['error' => 'Invalid action specified.']);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'An internal server error occurred. Check the logs for details.']);
}