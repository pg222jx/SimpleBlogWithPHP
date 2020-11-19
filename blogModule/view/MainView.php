<?php
namespace View;

class MainView {

    private static $createPost = 'create';

    private $createPostview;
    private $showPrivatePostsView;
    private $showPublicPostsView;

    public function __construct(\View\CreatePostView $createPostview, 
                                \View\ShowPrivatePostsView $showPrivatePostsView, 
                                \View\ShowPublicPostsView $showPublicPostsView) {
        $this->createPostView = $createPostview;
        $this->showPrivatePostsView = $showPrivatePostsView;
        $this->showPublicPostsView = $showPublicPostsView;
    }

    /**
     * Writes to output in Login Module.
     * 
     * @param isLoggedIn bool - If user is logged in or not.
     * @param username String - The logged in users username
     * @return String - HTML for the blog module.
     */
    public function generateMainViewHTML(bool $isLoggedIn, string $username) : string  {
        return '
        <br>
            <div class="blogContainer">
            ' . $this->renderRedirectLink($isLoggedIn) . '

            ' .  $this->renderView($isLoggedIn, $username)  . '
          </div>
        ';
    }

    /**
     * @param isLoggedIn bool - If user is logged in or not.
     * @param username String - The logged in users username
     */
    private function renderView(bool $isLoggedIn, string $username) : string {
        if (isset($_GET[self::$createPost]) && $isLoggedIn) {
            return $this->createPostView->response($username);
          } else {
            if($isLoggedIn) {
                return $this->showPrivatePostsView->response();
            } else {
                return $this->showPublicPostsView->response();
            }  
          }
    }

    /**
     * @param isLoggedIn bool - If user is logged in or not.
     * @return String - The href to be shown.
     */
    private function renderRedirectLink(bool $isLoggedIn) : string {
        if (isset($_GET[self::$createPost]) && $isLoggedIn) {
            return '<a href="?">Return</a>';
          } else if($isLoggedIn) {
              return '<a href="?' . self::$createPost . '">Create new post</a>';
          } else {
              return '';
          }
    }
}