<?php
require ('../routes.php');
require ('../Model/Models.php');

if (!Auth::loginStatus()){
	header('Location:' . URL_LOGIN_PAGE);
	exit();
} 
if(Auth::userType() != 'Student')  {
	header('Location:' . URL_WEBSITE_HOME);
	exit();
}

if (!(isset($_POST['qno']) && !empty($_POST['qno']) && Question::validateQuestionId($_POST['qno']) && Question::ifExist($_POST['qno']))) {
	die('Invalid Request');
}

/**
 * Check if question is live or not
 */
$question = Question::getQuestion($_POST['qno']);
if (!(strtotime($question.starTime) < time() && strtotime($question.endTime) > time())){
	die ("Question hasn't started yet or has ended already.");
}
/**
 * check if file uploaded or editor used
 * if editor then get the name of the file
 * if uploaded then verify that the uploaded file is of the type specified in question
 */
/**
 * get user id from session, and upload the file in the directory.
 */
/**
 * reirect to check compiling page.
 */
?>