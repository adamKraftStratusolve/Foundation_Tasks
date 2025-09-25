<?php

require_once 'person_repository.php';


$repository = new PersonRepository();
$action = $_GET['action'] ?? null;

header('Content-Type: application/json');

try {
    switch ($action) {
        case 'find':
            $firstName = $_GET['firstName'] ?? '';
            $surname = $_GET['surname'] ?? '';
            $dob = $_GET['dateOfBirth'] ?? '';

            $person = $repository->loadPerson($firstName, $surname, $dob);

            echo json_encode($person);
            break;

        case 'create':
            $data = json_decode(file_get_contents('php://input'), true);
            $person = new Person(
                $data['firstName'], $data['surname'], $data['dateOfBirth'],
                $data['emailAddress'], (int)$data['age']
            );
            $repository->savePerson($person);
            echo json_encode(['status' => 'success']);
            break;

        case 'update':
            $data = json_decode(file_get_contents('php://input'), true);
            $person = new Person(
                $data['firstName'], $data['surname'], $data['dateOfBirth'],
                $data['emailAddress'], (int)$data['age'], (int)$data['personId']
            );
            $repository->updatePerson($person);
            echo json_encode(['status' => 'success']);
            break;

        case 'delete':
            $data = json_decode(file_get_contents('php://input'), true);
            if (isset($data['personId'])) {
                $repository->deletePerson((int)$data['personId']);
                echo json_encode(['status' => 'success']);
            } else {
                throw new Exception('Person ID not provided for deletion.');
            }
            break;

        default:
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'Invalid action']);
            break;
    }
} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => $e->getMessage()]);
}