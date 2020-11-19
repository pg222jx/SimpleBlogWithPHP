<?php

/**
* PHP data structure for the blogpost
*/
namespace Model;

class BlogPostModel {
    public $author;
    public $title;
    public $blogPost;
    public $isPublic;
    public $uniqeId;

    public function __construct(string $author, string $title, string $blogPost, 
                                bool $isPublic, $uniqeId) {  
        $this->author = $author;
        $this->title = $title;
        $this->blogPost = $blogPost;
        $this->isPublic = $isPublic;
        $this->uniqeId = $uniqeId;
    }
}