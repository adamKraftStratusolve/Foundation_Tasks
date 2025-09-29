<?php
require_once "db_config.php";
require_once 'person_model.php';
class PersonRepository {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->pdo;
    }


    function run($query, $params = []){

        $statement = $this->pdo->prepare("$query");
        $statement->execute($params);

        return $statement;
    }

    function savePerson(Person $person) {
        $sql = "INSERT INTO People(FirstName, Surname, DateOfBirth, EmailAddress, Age) VALUES (?, ?, ?, ?, ?)";
        $params = [
            $person->firstName,
            $person->surname,
            $person->dateOfBirth,
            $person->emailAddress,
            $person->age
        ];

        $statement = $this->run($sql, $params);
        return $statement->rowCount() > 0;
    }

    function loadPerson($firstName, $surname, $dateOfBirth) {

        $sql = "SELECT * FROM People WHERE FirstName = ? AND Surname = ? AND DateOfBirth = ?";
        $params = [$firstName, $surname, $dateOfBirth];
        $statement = $this->run($sql,$params);
        $data = $statement->fetch();

        if (!$data) {
            return null;
        }

        return new Person($data['FirstName'], $data['Surname'], $data['DateOfBirth'], $data['EmailAddress'], $data['Age'], $data['PersonID']);

    }

    function deletePerson($personId) {

        $sql = "DELETE FROM People WHERE PersonID=?;";
        $params = [$personId];
        $statement = $this->run($sql, $params);

        return $statement->rowCount() > 0;
    }

    function loadAllPeople() {

        $sql = "SELECT * FROM People;";
        $statement = $this->run($sql);

        return $statement->fetchAll();
    }

    function deleteAllPeople() {

        $sql = "DELETE FROM People;";
        $statement = $this->run($sql);

        return $statement->rowCount() > 0;
    }

    function updatePerson(Person $person) {
        $sql = "UPDATE People SET FirstName = ?, Surname = ?, DateOfBirth = ?, EmailAddress = ?, Age = ? WHERE PersonID = ?";
        $params = [
            $person->firstName,
            $person->surname,
            $person->dateOfBirth,
            $person->emailAddress,
            $person->age,
            $person->personId
        ];
        $statement = $this->run($sql, $params);
        return $statement->rowCount() > 0;
    }
}