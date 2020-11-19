<?php
namespace Model;

require_once('blogModule/model/BlogPostModel.php');

class CreatePostModel {
    private $directory;

    public function __construct(string $directoryToBlogPosts) {
        $this->directory = $directoryToBlogPosts;
    }

    /**
    * @param title String - The blog posts title.
    * @param blogPost String - The blog post to be saved.
    * @param isPublic bool - If the user wants the blogpost to be public or not.
    * @param author String - The logged in users username.
    */
    public function savePostToDB(string $title, string $blogPost, bool $isPublic, string $author) {  
        $uniqueId = uniqid();
        $blogPost = new BlogPostModel($author, $title, $blogPost, $isPublic, $uniqueId);
        $jsonString = json_encode($blogPost);

        if($jsonString === FALSE) {
            throw new \Exception("JSON could not encode file correctly");
        }

        file_put_contents($this->directory . "{$uniqueId}.json", $jsonString);
    }
}