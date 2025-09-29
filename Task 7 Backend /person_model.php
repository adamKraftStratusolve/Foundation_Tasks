<?php
class Person {
    public $personId;
    public $firstName;
    public $surname;
    public $dateOfBirth;
    public $emailAddress;
    public $age;

    public function __construct(?string $firstName = null, ?string $surname = null, ?string $dateOfBirth = null, ?string $emailAddress = null, ?int $age = null, ?int $personId = null) {
        $this->firstName = $firstName;
        $this->surname = $surname;
        $this->dateOfBirth = $dateOfBirth;
        $this->emailAddress = $emailAddress;
        $this->age = $age;
        $this->personId = $personId;
    }
}