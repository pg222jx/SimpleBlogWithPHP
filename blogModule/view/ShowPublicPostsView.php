<?php
namespace View;

class ShowPublicPostsView {

    private $posts;

    /**
	* Generate HTML code for all the private posts
	* @return String - Writes to output.
	*/
    public function response() : string {
        return '
        <h3>These are the public haikus:</h3>
        <p>If you want to create your own haikus, please register as a member.</p>
            ' . $this->posts . '
        ';
    }
    
    /**
	* Generate HTML code for every private post
    * Writes to output.
    * @param posts array - All public posts.
	*/
    public function setPosts(array $posts) {
        foreach ($posts as $post) {
            $string = '        
                        <div class="postContainer">
                        <h4>' . $post->title . '</h4>
                        <p>' . nl2br($post->blogPost) . '</p>
                        </div>';

            $this->posts .= $string;
        }   
    }
}