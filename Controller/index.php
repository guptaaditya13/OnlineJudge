<?php
require ('../routes.php');
require ('../Model/Models.php');

/**
 * If user is alradye authenticated then he is redirected to his homepage
 */
// if($type = Auth::loginStatus()){

// 	if(Auth::userType() == 'Teacher'){
// 		header('Location:' . URL_TEACHER_HOME);
// 	} else {
// 		header('Location:' . URL_STUDENT_HOME);
// 	}

// 	exit();

// } else {
	/**
	 * Else request is served the Home page!
	 */
$arr = Question::getAll(Auth::loginStatus(), 10);
$dir = '../View/';
require($dir. 'Home.php');
// }
?>