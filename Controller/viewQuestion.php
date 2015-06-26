<?php 

require ('../routes.php');
require ('../Model/Models.php');

/**
 * For viewing a single question requesting either after submitting question or from home page
 * Getting questionId through GET request
 */

if (($_SERVER['REQUEST_METHOD'] == 'GET') && (isset($_GET['questionId'])) && !(empty($_GET['questionId'])) && Question::validateQuestionId($_GET['questionId'])) {
	if (Question::validateQuestionId($_GET['questionId'])){
		$question = Question::getQuestion($_GET['questionId']);
		$user = Auth::getUser($question->userID);
		//security
		Auth::joinSession();
		$_SESSION['questionId'] = $_GET['questionId'];
		$dir = "../View/";
		require($dir . "ViewQuestion.php");
	} else {
		die("Invalid question id");
	}
	
}
 ?>