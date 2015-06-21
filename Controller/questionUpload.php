<?php 
	
require ('../routes.php');
require ('../Model/Models.php');

if (!Auth::loginStatus()){
	header('Location:' . URL_LOGIN_PAGE);
	exit();
} elseif(Auth::userType() != 'Teacher')  {
	header('Location:' . URL_WEBSITE_HOME);
	exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!isset($_POST['tester']) || !isset($_POST['difficulty']) || !isset($_POST['question']) ){
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
		// var_dump(Auth::loginUser($username, sha1($password)));
		die("User not found! ");
	}

}
 ?>