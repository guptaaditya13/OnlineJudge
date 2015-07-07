<?php 
/**
 * If the script is requested by POST then users are authenticated
 * Else if it is requested by GET without authorization then login page is served
 * If user is authenticated then he is redirected to his homepage.
 */

require ('../routes.php');
require ('../Model/Models.php');
/**
* If user is already authenticated then he is redirected to his homepage
*/
if ($type = Auth::loginStatus()){

		if(Auth::userType() == 'Teacher'){
			header('Location:' . URL_TEACHER_HOME);
		} else {
			header('Location:' . URL_STUDENT_HOME);
		}

		exit();

} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['username']) && isset($_POST['password']) && !empty($_POST['username']) && !empty($_POST['password']) && Auth::validateCSRF("POST")){
			$username = $_POST['username'];
			$password = $_POST['password'];
		
		/**
		 * Validating the username & password provided
		 */
		if($error = Auth::validateData($username, $password)){
			die($error);
		}
		
		$user = Auth::loginUser($username, sha1($password));
		// var_dump($user);exit();
		if(is_a($user, 'Student')){
			header('Location: ' . URL_STUDENT_HOME);
			exit();
		} elseif (is_a($user, 'Teacher')) {
			header('Location: ' . URL_TEACHER_HOME);
			exit();
		} else {
			// var_dump(Auth::loginUser($username, sha1($password)));
			die("User not found! ");
		}
	} else {
		die ("Invalid POST request.");
	}
} else {
	/**
	 * Else he is served the login page!
	 */
	$dir = '../View/';
	require($dir . 'login.php');
	// die("serving login page");
}

?>