<?php

/**
* PHP data structure for users cookies
*/

namespace Model;

class UserCookieModel {
    public $username;
    public $password;
    public $timestamp;

    public function __construct(string $username, string $password, int $expires) {
        $this->username = $username;
        $this->password = $password;
        $this->timestamp = $expires;
    }
}