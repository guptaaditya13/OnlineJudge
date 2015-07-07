<?php 

require ('../routes.php');
require ('../Model/Models.php');
/**
 * Check if user is logged in or not to access the page
 * Logged in user should be a teacher.
 */
Auth::joinSession();
if (!Auth::loginStatus()){
	header('Location:' . URL_LOGIN_PAGE);
	exit();
} 
if(Auth::userType() != 'Teacher')  {
	header('Location:' . URL_WEBSITE_HOME);
	exit();
}
/**
 * If request method is post then process the data received by post.
 */
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
	/**
	 * All POST parameters have been collected, now sanitizing the data
	 */
	$questionText=Question::validateQuestionText($questionText);
	
	/**
	 * converting received date strings in standard date objects
	*/
	$startTime = Question::validateTime($startTime);
	$endTime = Question::validateTime($endTime);
	if($startTime == false || $endTime == false){
		die("Improper date format");
	}
	if (!Question::validateDates($startTime,$endTime)){
		echo "End date exceeded start date";
	}/**
	 * Change folder permissions later.
	 */
	if(Question::createNew($questionText, $questionImage, $startTime->format('Y-m-d H:i'), $endTime->format('Y-m-d H:i'), $maxMarks, $difficulty) && Question::createDirectoryForQuestion($_SESSION['qname'], 0777)){
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
