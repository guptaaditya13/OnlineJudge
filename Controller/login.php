<?php 
/**
 * If the script is requested by POST then data is processed else it is redirected to the welcome page of the website.
 */
require ('../Model/Models.php');
if (isset($_POST['submit'])) {
	if (!isset($_POST['username']) || !isset($_POST['password'])){
		die("Username and password missing in post request!");
	}
	$username = $_POST['username'];
	$password = $_POST['password'];

	require ('../Model/Models.php');
	/**
	 * Validating the username & password provided
	 */
	if($error = Auth::validateData($username, $password)){
		die($error);
	}
	$user = Auth::loginUser($username, sha1($password));
	$home_url = '';
	if(is_a($user, 'Student')){
		$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/StudentHome.php';
		header('Location: ' . $home_url);
		exit();
	} elseif (is_a($user, 'Teacher')) {
		header('Location: ' . $home_url);
		exit();
	} else {
		die("User not found!");
	}
} else {
	if($type = Auth::loginStatus()){
		$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . $type . 'Home.php';
		header('Location: ' . $home_url);
		exit();
	}
	require('../View/login.html');
}
?>