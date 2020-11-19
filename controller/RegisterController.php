<?php

namespace Controller;

class RegisterController {

    private $view;
    private $model;

    public function __construct(\View\RegisterView $view, \Model\RegisterModel $model) {
        $this->view = $view;
        $this->model = $model;
    }

    public function doRegisterNewUser() {
        if($this->view->wantsToRegister() && $this->view->isAllowedToRegister()) {
            $usernameInput = $this->view->getUsername();
            $passwordInput = $this->view->getPassword();
            
            if($this->model->doesUserExist($usernameInput, $passwordInput)) {
                $this->view->setUserAlreadyExistMessage();
            } else {
                $this->model->saveUserToDatabase($usernameInput, $passwordInput);
                $this->view->setUserRegisteredSuccessMessage();
            }
        }
    }
}
