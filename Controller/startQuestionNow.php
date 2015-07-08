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

if (!(isset($_GET['qno']) && !empty($_GET['qno']) && Question::validateQuestionId($_GET['qno']) && Question::ifExist($_GET['qno']))) {
	die('Invalid Request');
}

/**
 * Check if question is live or not
 */
$question = Question::getQuestion($_GET['qno']);
if(!$question->checkAccess($_SESSION['auth_id'])){
	die("You don't have required access to perform the task.");
}
$time = time();
if ((strtotime($question->startTime) < $time && strtotime($question->endTime) < $time) || (strtotime($question->startTime) > $time && strtotime($question->endTime) > $time)){
	if (Question::startQuestion($question->questionId,$time)) {
		die("Question started successfully");
	} else {
		die ("Failed to start Question");
	}
} else {
	die ("Can't start this question, edit manually");
}


?>