<?php

namespace Model;

require_once('model/UserCredentialsModel.php');

class RegisterModel {
    private $directory;

    public function __construct(string $pathToDirectory) {
        $this->directory = $pathToDirectory;
    }

    /**
     * @param username String - The users username.
     * @param password String - The users password.
     * @return Bool - If the user exists in database.
     */
    public function doesUserExist(string $username, string $password) : bool {
        $usernameExists = @file_get_contents($this->directory . "/{$username}.json");

        if($usernameExists) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * @param username String - The users username.
     * @param password String - The users password.
     */
    public function saveUserToDatabase(string $username, string $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $userCredentials = new UserCredentialsModel($username, $hashedPassword);

        $jsonString = json_encode($userCredentials);

        if($jsonString === FALSE) {
            throw new \Exception("JSON could not encode file correctly");
        }

        file_put_contents($this->directory . "/{$username}.json", $jsonString);	
    }
}