<?php

namespace App\Models;

class User {
    private $firstName;
    private $lastName;

    public function __construct($firstName, $lastName) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function getFullName() {
        return $this->firstName . ' ' . $this->lastName;
    }
}
