<?php

namespace View;

class RegisterView {
	private static $register = 'RegisterView::Register';
	private static $name = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $messageId = 'RegisterView::Message';

	private $message = '';

	/**
	 * Create HTTP response
	 * Should be called after a register attempt has been determined
	 *
	 * @return void BUT writes to output!
	 */
	public function response() {
		$this->setMessageValue();

		$response = $this->generateRegisterUserFormHTML($this->message);
		return $response;
	}

	/**
	 * Functions to determine users actions, to be accessed from controller
	 */
	public function wantsToRegister() : bool {
		if(isset($_POST[self::$register])) {
			return true;
		} else {
			return false;
		}
	}
	
	public function isAllowedToRegister() {
		if(isset($_POST[self::$register])) {
			if(empty($_POST[self::$name]) || empty($_POST[self::$password]) || empty($_POST[self::$passwordRepeat])) {
				return false;
			} else if(strlen($_POST[self::$name]) < 3 || strlen($_POST[self::$password]) < 6) {
				return false;
			} else if ($_POST[self::$passwordRepeat] != $_POST[self::$password] || ctype_alnum($_POST[self::$name]) == false) {
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}

	/**
	 * GET functions to get access to global variables from controller
	 */
	public function getUsername() {
		return $_POST[self::$name];
	}

	public function getPassword() {
		return $_POST[self::$password];
	}

	/**
	 * Functions that writes to outout depending on actions in controller
	 */	
	public function setUserAlreadyExistMessage() {
		$this->message = 'User exists, pick another username.';
	}
	
	public function setUserRegisteredSuccessMessage() {
		$this->message = 'Registered new user';
	}

	/**
	 * Sets value to shown message if unseccessful register attempt.
	 */
	private function setMessageValue() {
		if(isset($_POST[self::$register])) {
			if(empty($_POST[self::$name]) && empty($_POST[self::$password]) && empty($_POST[self::$passwordRepeat])) {
				$this->message = 'Username has too few characters, at least 3 characters. <br>
				Password has too few characters, at least 6 characters. <br>
				User exists, pick another username. <br>';
			} else if(empty($_POST[self::$name]) || strlen($_POST[self::$name]) < 3) {
				$this->message = 'Username has too few characters, at least 3 characters.<br>';
			} else if (empty($_POST[self::$password]) || strlen($_POST[self::$password]) < 6) {
				$this->message .= 'Password has too few characters, at least 6 characters.<br>';
			} else if ($_POST[self::$passwordRepeat] != $_POST[self::$password] || empty($_POST[self::$passwordRepeat])) {
				$this->message .= 'Passwords do not match.<br>';
			} else if (ctype_alnum($_POST[self::$name]) == false) {
				$this->message .= 'Username contains invalid characters.<br>';
			}
		}
	}

	/**
	* Generate HTML code for the register button.
	*
	* @param message String  - Output message.
	* @return String - Writes to output.
	*/
	private function generateRegisterUserFormHTML(string $message) : string {

		return '
		<form method="post" > 
		<fieldset>
			<legend>Register user - enter Username and password</legend>
			<p id="' . self::$messageId . '">' . $message . '</p>
			
			<label for="' . self::$name . '">Username :</label>
			<input type="text" id="' . self::$name . '" name="' . self::$name . '" 
			value="' . $this->removInvalidCharacters() . '" /><br>

			<label for="' . self::$password . '">Password :</label>
			<input type="password" id="' . self::$password . '" name="' . self::$password . '" /><br>

			<label for="' . self::$passwordRepeat . '">Repeat password :</label>
			<input type="password" id="' . self::$passwordRepeat . '" name="' . self::$passwordRepeat . '" /><br>

			<input id="' . self::$register . '" type="submit" name="' . self::$register . '" value="Register">
		</fieldset>
	</form>';
	}

	/**
	 * @return String - The username without invalid characters.
	 */
	private function removInvalidCharacters() : string {
		if(isset($_POST[self::$name])){
			return $usernameWithNoInvalidChars = Strip_tags($_POST[self::$name]);
		} else {
			return '';
		}
	}
}