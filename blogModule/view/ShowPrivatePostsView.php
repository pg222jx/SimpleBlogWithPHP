<?php
namespace View;

class ShowPrivatePostsView {

    private static $delete = 'ShowPrivatePostsView::Delete';
    private $posts;

    /**
	* Generate HTML code for all the private posts
	* @return String - Writes to output.
	*/
    public function response() : string {
        return '
        <h3>These are all your haikus:</h3>      
        ' . $this->posts . '
        ';
    }

    /**
    * Generate HTML code for every private post
    * @param posts array - All users posts.
	* Writes to output!
	*/
    public function setPosts(array $posts) {
        $ret = '';
             
        foreach ($posts as $post) {
            $ret .= '
            <div class="postContainer">
                    <h4>' . $post->title . '</h4>
                    <p>' . $this->printPrivateOrPublic($post) . '</p>
                    <p>' . nl2br($post->blogPost) . '</p>

                    <form method="post"> 
                        <fieldset class="deleteButtonFieldset">

                        <input type="hidden" value="' . $post->uniqeId . '" name="' . $post->uniqeId . '" />

                        <input class="deleteButton" type="submit" name="' . self::$delete . '" value="Delete"/>
                        </fieldset>
                    </form>
            </div>
            ';
        } 
        
        $this->posts = $ret;
    }

    /**
     * @return Bool - If the users has clicked the delete button.
     */
    public function wantsToDeletePost() : bool {
        if(isset($_POST[self::$delete])) {
            return true;
        } else {
            return false;
        }
    }

    public function getPostToDelete(array $posts) {
        foreach($posts as $post) {
            if(isset($_POST[$post->uniqeId])) {
               return $post;
            }
        }
    }

    /**
     * @param post - The post to be checked if it is public.
     * @return String - If the post is public or not.
     */
    private function printPrivateOrPublic($post) : string  {
        if($post->isPublic == true) {
            return 'This is a public post';
        } else {
            return 'This is a private post';
        }

    }
}