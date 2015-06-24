<?php 

require ('../routes.php');
require ('../Model/Models.php');

/**
 * For viewing a single question requesting either after submitting question or from home page
 * Getting questionId through GET request
 */

//isset($_GET['qusetionId'])
if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['questionId']) && Question::validateQuestionId($_GET['questionId'])) {
	$ques = new Question();
	$ques = Question::getQuestion($_GET['questionId']);
	$dir = "../View";
	require($dir . 'viewAQuestion.php');
}
 ?>