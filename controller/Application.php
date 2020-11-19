<?php

/**
 * Starting point of the application
 */

namespace Controller;

require_once('./blogModule/controller/Application.php');

require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('view/RegisterView.php');

require_once('model/RegisterModel.php');
require_once('model/LoginModel.php');

require_once('controller/RegisterController.php');
require_once('controller/LoginController.php');

class Application {

    private static $pathToDatabase = '../data';

    private $blogModule;

    private $username;

    private $registerView;
    private $loginView;
    private $dateTimeView;
    private $layoutView;
    
    private $registerModel;
    private $loginModel;

    private $registerController;
    private $loginController;
   
    public function __construct() {
        $this->registerView = new \View\RegisterView();
        $this->loginView = new \View\LoginView();
        $this->dateTimeView = new \View\DateTimeView();
        $this->layoutView = new \View\LayoutView();

        $this->registerModel = new \Model\RegisterModel(self::$pathToDatabase);
        $this->loginModel = new \Model\LoginModel(self::$pathToDatabase);

        $this->blogModule = new \blogModule\Controller\Application();
        
        $this->registerController = new \Controller\RegisterController($this->registerView, $this->registerModel);
        $this->loginController = new \Controller\LoginController($this->loginView, $this->loginModel);
    }

    public function run() {
        try {
            $this->changeState();
            $this->blogModule->changeState($this->loginModel->getUsernameSession());
            $this->generateOutput();
        } catch(\Exception $error) {

            //TODO: Write errors to an errorlog
            echo 'Somethng went wrong: ',  $error->getMessage(), "\n";
        }
	}

	private function changeState() {
         $this->loginController->doLogin();
         $this->loginController->doLogout();
         $this->registerController->doRegisterNewUser();
	}

	private function generateOutput() {
        $isLoggedIn = $this->loginModel->isLoggedIn();
        $username = $this->loginModel->getUsernameSession();
        
        if($this->layoutView->userClickedRegisterLink()) {
            $this->layoutView->render($isLoggedIn, $this->registerView, $this->dateTimeView, $this->blogModule, $username);
        } else {
            $this->layoutView->render($isLoggedIn, $this->loginView, $this->dateTimeView, $this->blogModule, $username);
        }
    }
}