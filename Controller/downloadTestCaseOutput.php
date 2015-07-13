<?php 
require ('../routes.php');
require ('../Model/Models.php');
$question = null;
/**
 * check if Get parameters are set correctly or not
 */
if (isset($_GET['qno']) && !empty($_GET['qno']) && Question::validateQuestionId($_GET['qno']) && Question::ifExist($_GET['qno']) && isset($_GET['tc']) && !empty($_GET['tc']) && is_numeric($_GET['tc'])) {

	$question = Question::getQuestion($_GET['qno']);
	/**
	 * check if
	 * 1. question is live or not
	 * 2. If not live then user type should be teacher
	 */
	if ((time() > (strtotime($question->startTime))) && (time() >= strtotime($question->endTime))){} 
	elseif (Auth::userType() == 'Teacher' && $question->checkAccess(Auth::getCurrentUser()->id)) {}
	else {
		// var_dump(Auth::userType());
		die ("Not authorized");
	}
	$tcNumber = $_GET['tc'];
	$tc = $question->getTestCase();
	/**
	 * if requested sample input exists then print it.
	 */
	if ($tcNumber <= $tc){
		$file = '../Uploads/Question/'.$question->name.'/test_case/'.$tcNumber.'out.txt';
		// var_dump($file);
		if (file_exists($file)) {
		    header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename='.basename($file));
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($file));
		    readfile($file);
		    exit;
		}
	} else {
		die ("file does not exist");
	}
} else {
/**
 * if not then kill the script
 */
	// var_dump($_GET);
	die("Improper request parameter.");
}