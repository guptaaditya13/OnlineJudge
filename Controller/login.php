<?php 
/**
 * If the script is requested by POST then users are authenticated
 * Else if it is requested by GET without authorization then login page is served
 * If user is authenticated then he is redirected to his homepage.
 */

require ('../routes.php');
require ('../Model/Models.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!isset($_POST['username']) || !isset($_POST['password'])){
		die("Username and password missing in post request!");
	}
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	/**
	 * Validating the username & password provided
	 */
	if($error = Auth::validateData($username, $password)){
		die($error);
	}
	
	$user = Auth::loginUser($username, sha1($password));
	
	if(is_a($user, 'Student')){
		header('Location: ' . URL_STUDENT_HOME);
		exit();
	} elseif (is_a($user, 'Teacher')) {
		header('Location: ' . URL_TEACHER_HOME);
		exit();
	} else {
		die("User not found!");
	}

} else {
	/**
	 * If user is alradye authenticated then he is redirected to his homepage
	 */
	if($type = Auth::loginStatus()){

		if(Auth::userType() == 'Teacher'){
			header('Location:' . URL_TEACHER_HOME);
		} else {
			header('Location:' . URL_STUDENT_HOME);
		}

		exit();

	} else {
		/**
		 * Else he is served the login page!
		 */
	// require('../View/login.php');
		die("serving login page");
	}
}
?>