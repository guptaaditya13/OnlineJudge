<?php 

require ('../routes.php');
require ('../Model/Models.php');
Auth::joinSession();
/**
 * For viewing a single question either after submitting question or from home page
 * Getting questionId through GET request
 */
if (($_SERVER['REQUEST_METHOD'] == 'GET') && (isset($_GET['questionId'])) && !(empty($_GET['questionId'])) && Question::validateQuestionId($_GET['questionId'])) {
	if (Question::validateQuestionId($_GET['questionId'])){
		$question = Question::getQuestion($_GET['questionId']);
		$sample = $question->getSampleInput();
		$inp = array();
		$out = array();
		for ($i=1; $i <= $sample; $i++) { 
			$inp[] = file_get_contents('../Uploads/Question/'.$question->name.'/sample/'.$i.'.txt');
			$out[] = file_get_contents('../Uploads/Question/'.$question->name.'/sample/'.$i.'out.txt');
		}
		// var_dump($inp);
		// var_dump($out);
		// exit();
		$user = Auth::getUser($question->userID);
		$_SESSION['questionId'] = $_GET['questionId'];
		$dir = "../View/";
		$arr = array();
		require($dir . "ViewQuestion.php");
	} else {
		die("Invalid question id");
	}
	
}

?>