<?php

namespace Model;

require_once('model/UserCookieModel.php');

class LoginModel {
    private static $loggedIn = 'LoginModel::isLoggedIn';
    private static $browserInfo = 'LoginModel::browserInfo';
    private static $userAgent = 'HTTP_USER_AGENT';
    private static $username = 'LoginModel::Username';
    private $directory;
    private $directoryToCookieDb = '../cookieDb';

    public function __construct(string $pathToDirectory) {
        $this->directory = $pathToDirectory;
    }

    /**
     * Checks if user is logged in and is logged in from the same browser to prevent session hijacking.
     * 
     * @return Bool - If user is logged in.
     */
    public function isLoggedIn() : bool {
        if(isset($_SESSION[self::$loggedIn]) 
            && $_SESSION[self::$loggedIn] == true 
            && isset($_SESSION[self::$browserInfo]) 
            && $_SESSION[self::$browserInfo] == $_SERVER[self::$userAgent]) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param username String - The users username.
     * @param password String - The users password.
     */
    public function doesUserExist(string $username, string $password) : bool {
        if(@file_get_contents($this->directory . "/{$username}.json") === FALSE) {
            return false;
        } else {
            $userCredentials = json_decode(@file_get_contents($this->directory . "/{$username}.json"));

            if($userCredentials === FALSE) {
                throw new \Exception("JSON could not be parsed correctly");
            }

            // Verify hashed password
            if(password_verify($password, $userCredentials->password) && $userCredentials->username == $username){
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * @param username String - The logged in users cookie username.
     * @param password String - The logged in users temporary cookie password.
     * @param expires int - When the cookies expire.
     */
    public function setCookieToDb(string $username, string $password, int $expires) {
        $userCredentials = new UserCookieModel($username, $password, $expires);
                
        $jsonString = json_encode($userCredentials);

        if($jsonString === FALSE) {
            throw new \Exception("JSON could not encode file correctly");
        }

        file_put_contents($this->directoryToCookieDb . "/{$username}.json", $jsonString);
    }

    /**
     * @param username String - The users username in cookie.
     * @param password String - The users password in cookie.
     * @param expires int - When the cookies expires. 
     * @return Bool - If the cookies are correct.
     */
    public function isRecievedCookieCorrect(string $username, string $password, int $expires) : bool {
        if(@file_get_contents($this->directoryToCookieDb . "/{$username}.json") == FALSE) {
            return false;
        } else {
            $userCredentials = json_decode(@file_get_contents($this->directoryToCookieDb . "/{$username}.json"));

            if($userCredentials === FALSE) {
                throw new \Exception("JSON could not be parsed correctly");
            }
            
            // Checks so users credentials matches the one i the cookie database
            if($password == $userCredentials->password && $userCredentials->timestamp == $expires){
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Sets the session of the browser and server to prevent session hijacking.
     * 
     * @param isLoggedIn bool - If the user has logged in or logged out. 
     */
    public function setIsLoggedIn(bool $isLoggedIn) {
        $_SESSION[self::$browserInfo] = $_SERVER[self::$userAgent];
        $_SESSION[self::$loggedIn] = $isLoggedIn;
    }

    /**
     * Sets the users username to session to be reached from other modules.
     * 
     * @param username String - The logged in users username. 
     */
    public function setUsernameSession(string $username) {
        $_SESSION[self::$username] = $username;
    }

    /**
     * @return String The logged in users username stored in session. 
     */
    public function getUsernameSession() : string {
        if(!empty($_SESSION[self::$username])) {
            return $_SESSION[self::$username];
        } else {
            return '';
        }
    }
}