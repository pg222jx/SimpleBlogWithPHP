<?php
namespace Controller;

class ShowPostsController {

    private $privateView;
    private $publicView;
    private $model;

    public function __construct(\View\ShowPrivatePostsView $privateView, 
                                \View\ShowPublicPostsView $publicView, 
                                \Model\ShowPostsModel $model) {
        $this->privateView = $privateView;
        $this->publicView = $publicView;
        $this->model = $model;
    }

    /**
     * @param author String - The logged in users username.
     */
    public function doDeletePost(string $author) {
        if($this->privateView->wantsToDeletePost()) {
            $posts = $this->model->getPrivatePosts($author);
            $postToDelete = $this->privateView->getPostToDelete($posts);
            $this->model->deletePost($postToDelete);
        }
    }

    /**
     * @param author String - The logged in users username.
     */
    public function doShowPost(string $author) {
        $this->showPrivatePosts($author);
        $this->showPublicPosts();
    }

    /**
     * @param author String - The logged in users username.
     */
    private function showPrivatePosts(string $author) {
        $posts = $this->model->getPrivatePosts($author);
        $this->privateView->setPosts($posts);
    }

    private function showPublicPosts() {
        $posts = $this->model->getPublicPosts();
        $this->publicView->setPosts($posts);
    }
}