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
	// var_dump($_POST);echo"<br><br><br><br><br>";var_dump($_FILES);exit();
	if (!isset($_POST['difficulty']) || empty($_POST['difficulty']) || !isset($_POST['title']) || empty($_POST['title']) || !isset($_POST['FullExplain']) || empty($_POST['FullExplain']) || !isset($_POST['start_date']) || empty($_POST['start_date']) || !isset($_POST['end_date']) || empty($_POST['end_date']) || !isset($_POST['maxMarks']) || empty($_POST['maxMarks'])){
		die("Something missing in post request!");
	}
	$difficulty = $_POST['difficulty'];
	$questionTitle = $_POST['title'];
	$question = $_POST['FullExplain'];
	$startTime = $_POST['start_date'];
	$endTime = $_POST['end_date'];
	$maxMarks = $_POST['maxMarks'];
	/**
	 * All POST parameters have been collected, now sanitizing the data
	 */
		
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
	}
	$upload = empty($_FILES['fileToUpload']['name']);
	$arr = false;
	if ($upload) {	
	} else {
		$arr = is_array($_FILES['fileToUpload']['name']);
		if($arr){
			for ($i=0; $i < count($_FILES['fileToUpload']['name']); $i++) { 
				$var = Question::checkImageAttachment($_FILES['fileToUpload']['name'][$i],$_FILES['fileToUpload']['type'][$i], $_FILES['fileToUpload']['tmp_name'][$i], $_FILES['fileToUpload']['error'][$i], $_FILES['fileToUpload']['size'][$i]);
				if($var){
					die($var);
				}
			}
		} else {
			$var = Question::checkImageAttachment($_FILES['fileToUpload']['name'],$_FILES['fileToUpload']['type'], $_FILES['fileToUpload']['tmp_name'], $_FILES['fileToUpload']['error'], $_FILES['fileToUpload']['size']);
			if($var){
				die($var);
			}
		}
	}
	/**
	 * Change folder permissions later.
	 */
	if(Question::createNew($questionTitle, $question, $startTime->format('Y-m-d H:i'), $endTime->format('Y-m-d H:i'), $maxMarks, $difficulty, '',$upload, $arr)){
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
