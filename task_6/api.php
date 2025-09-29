<?php
header('Content-Type: application/json');

require_once 'person_repository.php';
require_once 'person_model.php';

$repo = new PersonRepository();

$action = $_REQUEST['action'] ?? null;

switch ($action) {
    case 'create':
        $data = json_decode(file_get_contents('php://input'));
        $person = new Person($data->firstName, $data->surname, $data->dateOfBirth, $data->emailAddress, $data->age);
        $repo->savePerson($person);
        echo json_encode(['status' => 'success']);
        break;

    case 'read':
        $people = $repo->loadAllPeople();
        echo json_encode($people);
        break;

    case 'update':
        $data = json_decode(file_get_contents('php://input'));
        $person = new Person($data->firstName, $data->surname, $data->dateOfBirth, $data->emailAddress, $data->age, $data->personId);
        $repo->updatePerson($person);
        echo json_encode(['status' => 'success', 'message' => 'Person updated successfully.']);
        break;


    case 'delete':
        $data = json_decode(file_get_contents('php://input'));
        if (isset($data->personId)) {
            $repo->deletePerson($data->personId);
            echo json_encode(['status' => 'success']);
        }
        break;

    case 'find':
        $firstName = $_GET['firstName'] ?? null;
        $surname = $_GET['surname'] ?? null;
        $dob = $_GET['dateOfBirth'] ?? null;
        $person = $repo->loadPerson($firstName, $surname, $dob);
        echo json_encode($person);
        break;

    default:
        http_response_code(400); // Bad Request
        echo json_encode(['error' => 'Invalid action specified.']);
        break;
}