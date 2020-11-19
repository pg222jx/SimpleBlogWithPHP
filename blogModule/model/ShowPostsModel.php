<?php
namespace Model;

class ShowPostsModel {

    private $directory;

    public function __construct(string $directoryToBlogPosts) {
        $this->directory = $directoryToBlogPosts;
    }

    /**
     * @param postToDelete Object - The post the user wants to delete.
     */
    public function deletePost($postToDelete) {

        $postExists = @file_get_contents($this->directory . "{$postToDelete->uniqeId}.json");
        
        if($postExists === FALSE) {
            throw new \Exception("File could not be loaded correctly");
        } else if ($postExists) {
            unlink($this->directory . "{$postToDelete->uniqeId}.json");
  
            //https://www.w3.org/TR/WCAG20-TECHS/H76.html
            // TODO: This is here bacause we need to reload page for the deleted post 
            // to disappear from page. Remove this and create a better solution to delete post
            // without reload.
            echo "<meta http-equiv='refresh' content='0'>";// Creates a true reload of page
        }
    }

    public function getPublicPosts() : array {
        $files = $this->getPostsFromDb();
        $posts = array();

        foreach($files as $file) {
            $fileContent = @file_get_contents($this->directory . $file);

            if($fileContent === FALSE) {
                throw new \Exception("File could not be loaded correctly");
            } 

            $file = json_decode($fileContent);

            if($file === FALSE) {
                throw new \Exception("JSON could not be parsed correctly");
            }

            //Only adds the posts that the users has set to public
            if($file->isPublic) {
                array_push($posts, $file);
            }
        }
        return $posts;
    }

    /**
     * @param author String - The logged in users username.
     */
    public function getPrivatePosts(string $author) : array { 
        $files = $this->getPostsFromDb();
        $posts = array();

        foreach($files as $file) {
            $fileContent = @file_get_contents($this->directory . $file);

            if($fileContent === FALSE) {
                throw new \Exception("File could not be loaded correctly");
            } 

            $file = json_decode($fileContent);

            if($file === FALSE) {
                throw new \Exception("JSON could not be parsed correctly");
            }
            // Adds only the posts that are written by the logged in user.
            if($file->author == $author) {
                array_push($posts, $file);
            }
        }
        return $posts;
    }

    private function getPostsFromDb() : array {
        $posts = scandir($this->directory);

        if($posts === FALSE) {
            throw new \Exception("Directory could not be loaded correctly");
        }

        $posts = array_slice($posts, 2); 
        return $posts; 
    }
}