<?php

namespace Controller;

class LoginController {

    private $view;
    private $model;

    public function __construct(\View\LoginView $view, \Model\LoginModel $model) {
        $this->view = $view;
        $this->model = $model;
    }

    public function doLogin() {
        $this->checkIfUserIsLoggedIn();
        $this->logInUser();
    }

    public function doLogout() {
        //If user is not logged in set message to nothing
        if(!$this->model->IsLoggedIn()) {
            $this->view->resetMessage();
        }

        if($this->model->IsLoggedIn() && $this->view->wantsToLogout()) {
            $this->model->setIsLoggedIn(false);
            $this->view->unsetCookies();
            $this->view->setLogOutMessage();
        }
    }

    private function checkIfUserIsLoggedIn() {
        //If user is already logged in set message to nothing else check for cookies
        if($this->model->IsLoggedIn()) {
            $this->view->resetMessage();
        } else if ($this->view->isCookiesSet()) {
            $username = $this->view->getCookieUsername();
            $password = $this->view->getCookiePassword();
            $expires = $this->view->getExpireTimeCookie();
          
            if($this->model->isRecievedCookieCorrect($username, $password, $expires)) {
                $this->model->setIsLoggedIn(true);
                $this->view->setCookieMessage();
            }
        } 
    }

    private function logInUser() {
        if($this->view->wantsToLogin() && !$this->model->IsLoggedIn()) {
            $usernameInput = $this->view->getUsername();
            $passwordInput = $this->view->getPassword();

            // Sets session for username to be accessed from blog module
            $this->model->setUsernameSession($usernameInput);
            
            if($this->model->doesUserExist($usernameInput, $passwordInput)) {
                $this->model->setIsLoggedIn(true);
                $this->view->setLoginSuccessMessage();

                $this->chechIfCookiesShouldBeSet();
            }
        }
    }

    private function chechIfCookiesShouldBeSet() {
        if($this->view->wantsToBeRemembered()) {
            $this->view->setCookies();

            $cookieUsername = $this->view->getCookieUsername();
            $cookiePassword = $this->view->getCookiePassword();
            $cookieExpires = $this->view->getExpireTimeCookie();
            $this->model->setCookieToDb($cookieUsername, $cookiePassword, $cookieExpires);
        }
    }
}