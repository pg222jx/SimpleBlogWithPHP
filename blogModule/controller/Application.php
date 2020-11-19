<?php

/**
 * Starting point of the blogModule application
 */

namespace blogModule\Controller;

require_once('blogModule/view/ShowPrivatePostsView.php');
require_once('blogModule/view/ShowPublicPostsView.php');
require_once('blogModule/view/CreatePostView.php');
require_once('blogModule/view/MainView.php');

require_once('blogModule/model/CreatePostModel.php');
require_once('blogModule/model/ShowPostsModel.php');

require_once('blogModule/controller/CreatePostController.php');
require_once('blogModule/controller/ShowPostsController.php');


class Application {

    private $directoryToBlogPosts = './../allBlogPosts/';

    private $showPrivatePostsView;
    private $showPublicPostsView;
    private $createPostView;
    private $mainView;

    private $createPostController;
    private $showPostsController;

    private $createPostModel;
    private $showPostsModel;

    public function __construct() {       
        $this->showPrivatePostsView = new \View\ShowPrivatePostsView();
        $this->showPublicPostsView = new \View\ShowPublicPostsView();
        $this->createPostView = new \View\CreatePostView();
        $this->mainView = new \View\MainView($this->createPostView, $this->showPrivatePostsView, $this->showPublicPostsView);

        $this->createPostModel = new \Model\CreatePostModel($this->directoryToBlogPosts);
        $this->showPostsModel = new \Model\ShowPostsModel($this->directoryToBlogPosts);

        $this->createPostController = new \Controller\CreatePostController($this->createPostView, $this->createPostModel);        
        $this->showPostsController = new \Controller\ShowPostsController($this->showPrivatePostsView, $this->showPublicPostsView, $this->showPostsModel);
    }

    /** 
     * @param username String - The username that is set on log in in the login module.
     */
	public function changeState(string $username) {
        $this->createPostController->doCreateBlogPost($username);
        $this->showPostsController->doShowPost($username);
        $this->showPostsController->doDeletePost($username);
	}

    /**
     * @param isLoggedIn bool - If user i logged in or not set in the login module.
     * @param username String - The username that is set on log in in the login module.
     */
	public function generateOutput(bool $isLoggedIn, string $username) {
        return $this->mainView->generateMainViewHTML($isLoggedIn, $username);
    }
}