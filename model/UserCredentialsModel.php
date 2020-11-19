<?php

/**
* PHP data structure for users credentials
*/

namespace Model;

class UserCredentialsModel {
    public $username;
    public $password;

    public function __construct(string $username, string $password) {
        $this->username = $username;
        $this->password = $password;
    }
}