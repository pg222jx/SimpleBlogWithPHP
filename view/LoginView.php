<?php

namespace View;

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private static $timestamp = 'LoginView::Timestamp';

	private $message = '';
	
	/**
	 * Create HTTP response
	 * Should be called after a login attempt has been determined
	 *
	 * @return String - Writes to standard output.
	 */
	public function response(bool $isLoggedIn) : string {

		$this->setMessageValue($isLoggedIn);
			
		if($isLoggedIn) {
			$response = $this->generateLogoutButtonHTML($this->message);
		} else  {
			$response = $this->generateLoginFormHTML($this->message);
		}	
		return $response;
	}

	/**
	 * Functions to determine users actions, to be accessed from controller
	 */
	public function wantsToLogin() : bool {
		if(isset($_POST[self::$login])) {
			if(!empty($_POST[self::$name]) && !empty($_POST[self::$password])) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function wantsToBeRemembered() : bool {
		if(!empty($_POST[self::$keep])) {
			return true;
		} else {
			return false;
		}
	}

	public function wantsToLogout() : bool {
		if(isset($_POST[self::$logout])) {
			return true;
		} else {
			return false;
		}
	}

	public function setCookies() {
		$randomPassword = $this->generateTemporaryPassword();
		$expires = time() + 3600;

		setCookie(self::$cookieName, $_POST[self::$name], $expires, "/");
		setCookie(self::$cookiePassword, $randomPassword, $expires,  "/");
		setCookie(self::$timestamp, $expires, $expires,  "/");

		$_COOKIE[self::$cookieName] = $_POST[self::$name];
		$_COOKIE[self::$cookiePassword] = $randomPassword;
		$_COOKIE[self::$timestamp] = $expires;
	}

	public function unsetCookies() {
		setcookie(self::$cookieName, '', 1);
		setcookie(self::$cookiePassword, '', 1);
		setCookie(self::$timestamp, '', 1);
	}

	public function isCookiesSet() : bool {
		if (!empty($_COOKIE[self::$cookieName]) 
			&& !empty($_COOKIE[self::$cookiePassword]) 
			&& !empty($_COOKIE[self::$timestamp])) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * GET functions to get access to global variables from controller
	 */
	public function getUsername() : string {
			return $_POST[self::$name];	
	}

	public function getPassword() : string {
		return $_POST[self::$password];
	}

	public function getCookieUsername() : string {
		return $_COOKIE[self::$cookieName];
	}

	public function getCookiePassword() : string {
		return $_COOKIE[self::$cookiePassword];
	}

	public function getExpireTimeCookie() : string {
		return $_COOKIE[self::$timestamp];
	}

	/**
	 * Functions that writes to outout depending on actions in controller
	 */
	public function resetMessage() {
		$this->message = '';
	}
	
	public function setLoginSuccessMessage() {
		if(!empty($_POST[self::$keep])) {
			$this->message = 'Welcome and you will be remembered';
		} else {
			$this->message = 'Welcome';
		}
	}
	
	public function setLogOutMessage() {
		$this->message = 'Bye bye!';
	}
	
	public function setCookieMessage() {
		$this->message = 'Welcome back with cookie';
	}

	/**
	 * Sets value to shown message if unseccessful login attempt.
	 */
	private function setMessageValue(bool $isLoggedIn) {
		if(isset($_POST[self::$login])) {
			if(empty($_POST[self::$name])) {
				$this->message .= 'Username is missing';
			} else if(empty($_POST[self::$password])) {
				$this->message .= 'Password is missing';
			} else if (!$isLoggedIn) {
				$this->message .= 'Wrong name or password';
			} 
		}
	}

	private function generateTemporaryPassword(int $length = 20) {
		return substr(sha1(rand()), 0, $length);
	}
	
	/**
	* Generate HTML code for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML(string $message) : string {
		return '
			<form action="/" method="post">
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	/**
	* Generate HTML code for the login form
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML(string $message) : string {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" 
					value="' . (isset($_POST[self::$name]) ? $_POST[self::$name] : "") . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}
}