<?php
namespace Controller;

class CreatePostController {

    private $view;
    private $model;

    public function __construct(\View\CreatePostView $view, \Model\CreatePostModel $model) {
        $this->view = $view;
        $this->model = $model;
    }

    /**
     * @param author String - The logged in users username.
     */
    public function doCreateBlogPost(string $author) {
        if($this->view->wantsToSavePost()) {
            $title = $this->view->getTitle();
            $blogPost = $this->view->getBlogPost();
            $isPublic = $this->view->shouldPostBePublic();

            $this->model->savePostToDB($title, $blogPost, $isPublic, $author);
        }
    }

}