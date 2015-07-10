<?php 
/**
 * functions required to submit the answer.
 */
require ('../routes.php');
require ('../Model/Models.php');

if (($_SERVER['REQUEST_METHOD'] == 'GET') && (isset($_GET['questionId'])) && !(empty($_GET['questionId']))) {
	if (Question::validateQuestionId($_GET['questionId'])){
		//security
		Auth::joinSession();
		$_SESSION['questionId'] = $_GET['questionId'];
		$dir = "../View/";
		require($dir . "submitAnswer.php");
	} else {
		die("Invalid question id");
	}
	
}
 ?>