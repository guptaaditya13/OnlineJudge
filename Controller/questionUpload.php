<?php 
	
require ('../routes.php');
require ('../Model/Models.php');


echo Auth::loginStatus();
echo "6541d5s4ge6";
die("x");
if (!Auth::loginStatus()){
	header('Location:' . URL_LOGIN_PAGE);
	exit();
} elseif(Auth::userType() != 'Teacher')  {
	header('Location:' . URL_WEBSITE_HOME);
	exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!isset($_POST['tester']) || !isset($_POST['difficulty']) || !isset($_POST['question']) || !isset($_POST['start_time']) || !isset($_POST['end_time'])){
		die("Something missing in post request!");
	}
	$tester = $_POST['tester'];
	$difficulty = $_POST['difficulty'];
	$questionText = $_POST['question'];
	$startTime = $_POST['startTime'];
	$endTime = $_POST['endTime'];
	$maxMarks = $_POST['mm'];
	$questionImage = "set_this";
	/**
	 * Validating of question --------write it
	 */
	
	/**
	 * adding question
	 */
	$ques = Question::createNew($questionText, $questionImage, $startTime, $endTime, $maxMarks, $difficulty);
	header('Location:' . URL_WEBSITE_HOME);
	exit();
}
?>
