<?php 
require ('../routes.php');
require ('../Model/Models.php');

if (Auth::loginStatus()){
	header('Location:' . URL_LOGIN_PAGE);
	exit();
} 
if(Auth::userType() != 'Teacher')  {
	header('Location:' . URL_WEBSITE_HOME);
	exit();
}

if (!(isset($_GET['qno']) && !empty($_GET['qno']) && Question::validateQuestionId($_POST['qno']) && Question::ifExist($_POST['qno']))) {
	die('Invalid Request');
}

$question = Question::getQuestion($_POST['qno']);
/**
 * Checking if user has access to perform the task or not.
 */
if(!$question->checkAccess($_SESSION['auth_id'])){
	die("You don't have required access to perform the task.");
}
$time = time();

/**
 * Check if question is live or not
 */
if (strtotime($question.starTime) < $time && strtotime($question.endTime) > $time){
	if (Question::endQuestion($question->questionId,$time)) {
		die("Question ended successfully");
	} else {
		die ("Failed to end Question");
	}
} else {
	die ("Question hasn't started yet or has ended already.");
}


?>