<?php

namespace View;

class LayoutView {

  private static $register = 'register';

  public function userClickedRegisterLink() : bool {
    if(isset($_GET[self::$register])) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * Echos the HTML body to page
   * 
   * @param isLoggedIn String - If a user is logged in.
   * @param view - Register or Login view.
   * @param dateTimeView DateTimeView - The view to show date and time.
   * @param blogModule \blogModule\Controller\Application - The Blog module.
   * @param username String - The logged in users username from session.
   */
  public function render(bool $isLoggedIn, $view, DateTimeView $dateTimeView, \blogModule\Controller\Application $blogmodule, string $username) {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <link rel="stylesheet" href="style.css">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          
          ' . $this->renderIsLoggedIn($isLoggedIn) . '

          ' . $this->renderRedirectLink($isLoggedIn) . '
         
         <br><br>
          <div class="container">
              ' . $view->response($isLoggedIn)  . '

              ' . $blogmodule->generateOutput($isLoggedIn, $username) . '
              
              ' . $dateTimeView->showDateTime() . '
          </div>
         </body>
      </html>
    ';
  }

  /**
   * @param isLoggedIn String - If a user is logged in.
   * @return String - That the user is logged in or not.
   */
  private function renderIsLoggedIn(bool $isLoggedIn) : string {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }
 /**
  * @param isLoggedIn String - If a user is logged in.
  * @return String - The href to be shown depending on logged in or not.
  */
  private function renderRedirectLink(bool $isLoggedIn) : string  {
    if (isset($_GET[self::$register])) {
      return '<a href="?">Back to login</a>';
    } else if (!$isLoggedIn) {
        return '<a href="?' . self::$register . '">Register a new user</a>';
    } else {
        return '';
    }
  }
}
