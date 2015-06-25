<?php 

require ('../routes.php');
require ('../Model/Models.php');

/**
 * For viewing a single question requesting either after submitting question or from home page
 * Getting questionId through GET request
 */

//isset($_GET['qusetionId'])
if (($_SERVER['REQUEST_METHOD'] == 'GET') && (isset($_GET['questionId'])) && !(empty($_GET['questionId'])) && Question::validateQuestionId($_GET['questionId'])) {
	if (Question::validateQuestionId($_GET['questionId'])){
		$question = new Question();
		$question = Question::getQuestion($_GET['questionId']);
		$user = Auth::getUser($question->userID);
		$dir = "../View/";
		require($dir . "ViewQuestion.php");
	} else {
		die("Invalid question id");
	}
	
}
 ?>