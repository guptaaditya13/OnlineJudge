<?php 

require ('../routes.php');
require ('../Model/Models.php');

/**
 * For viewing a single question either after submitting question or from home page
 * Getting questionId through GET request
 */

/**
 * Check later
 */
if (($_SERVER['REQUEST_METHOD'] == 'GET') && (isset($_GET['questionId'])) && !(empty($_GET['questionId'])) && Question::validateQuestionId($_GET['questionId'])) {
	if (Question::validateQuestionId($_GET['questionId'])){
		$question = Question::getQuestion($_GET['questionId']);
		$user = Auth::getUser($question->userID);
		$dir = "../View/";
		require($dir . 'viewQuestion.php');
	} else {
		die("Invalid question id");
	}
	
}
 ?>