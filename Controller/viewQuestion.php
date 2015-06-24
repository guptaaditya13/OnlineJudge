<?php 

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['qusetionId']) && !empty($_GET['questionId']) && Question::validateQuestionId($_GET['questionId'])) {
	# code...
}


 ?>