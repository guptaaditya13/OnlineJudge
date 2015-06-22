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
Auth::joinSession();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!isset($_POST['difficulty']) || !isset($_POST['question']) || !isset($_POST['start_date']) || !isset($_POST['end_date']) || empty($_POST['difficulty']) || empty($_POST['question']) || empty($_POST['start_date']) || empty($_POST['end_date'])){
		die("Something missing in post request!");
	}
	$difficulty = $_POST['difficulty'];
	$questionText = $_POST['question'];
	$startTime = $_POST['start_date'];
	$endTime = $_POST['end_date'];
	$maxMarks = 100;
	$questionImage = '';
	if (!Question::validateQuestionTime($startTime, $endTime)) {
		die("invalid question Text");
	}
	$questionText=Question::validateQuestionText($questionText);
	/**
	 * Date validation is missing
	 */

	if(Question::createNew($questionText, $questionImage, $startTime, $endTime, $maxMarks, $difficulty)){
		header('Location:' . URL_WEBSITE_HOME);
		exit();	
	} else {
		die("unable to create new entry");
	}
	
}else{
	$dir = '../View/';
	require($dir . 'QuestionUpload.php');
	exit();
}
?>
