<?php
namespace View;

class CreatePostView {

	private static $title = 'CreatePostView::Title';
	private static $author = 'CreatePostView::Author';
	private static $public = 'CreatePostView::Public';
	private static $blogPost = 'CreatePostView::BlogPost';
	private static $save = 'CreatePostView::Save';

	/**
	* Create HTTP response
	* Should be called after a create post attempt has been determined
	*
	* @param username String - The logged in users username.
	* @return void BUT writes to output!
	*/
	public function response(string $username) {
		$response = $this->generateCreatePostFormHTML($username);
		return $response;
	}

	/**
	 * Functions to determine users actions, to be accessed from controller
	 */
	public function wantsToSavePost()  : bool {
		if(isset($_POST[self::$save])) {
			return true;
		} else {
			return false;
		}
	}

	public function shouldPostBePublic() : bool {
		if(!empty($_POST[self::$public])) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * GET functions to get access to global variables from controller
	 */
	public function getTitle() : string {
		return $_POST[self::$title];
	}

	public function getBlogPost() : string {
		return $_POST[self::$blogPost];
	}

	/**
	* Generate HTML code for the create post form
	* @param username String - The logged in users username.
	* @return  void, BUT writes to output!
	*/
    private function generateCreatePostFormHTML(string $username) : string {
		return '
			<div class="rules">
				<h3>Before you begin:</h3>
				<p>Remember the rules of haiku</p>
				<p>The first and third row is 5 syllables</p>
				<p>The second row is 7 syllables</p>
				<p>5 + 7 + 5</p>
			</div>
			<form action="/" method="post"> 
				<fieldset>
					<legend>Create post</legend>
					<label for="' . self::$author . '">Author :</label><br>
                    <input type="text" id="' . self::$author . '" name="' . self::$author . '" value="' . $username . '" readonly/>
					
					<br>

					<label for="' . self::$title . '">Title :</label><br>
                    <input type="text" id="' . self::$title . '" name="' . self::$title . '" value="" required/>
                    
					<br>

					<label for="' . self::$blogPost . '">Blog Post :</label> <br>
                    <textarea id="' . self::$blogPost . '" name="' . self::$blogPost . '" rows="20" cols="70" required></textarea>

					<br>
					
					<label for="' . self::$public . '">Make post public :</label>
					<input type="checkbox" id="' . self::$public . '" name="' . self::$public . '" />
					
					<br>

					<input type="submit" name="' . self::$save . '" value="Save" />
				</fieldset>
			</form>
		';
    }

}