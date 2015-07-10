<?php
require ('../routes.php');
require ('../Model/Models.php');

if (!Auth::loginStatus()){
	header('Location:' . URL_LOGIN_PAGE);
	exit();
} 
if(Auth::userType() != 'Student')  {
	header('Location:' . URL_WEBSITE_HOME);
	exit();
}

if (!(isset($_GET['questionId']) && !empty($_GET['questionId']) && Question::validateQuestionId($_GET['questionId']) && Question::ifExist($_GET['questionId']))) {
	die('Invalid Request');
}

/**
 * Check if question is live or not
 */
$question = Question::getQuestion($_GET['questionId']);
if (!(strtotime($question->startTime) < time() && strtotime($question->endTime) > time())){
	die ("Question hasn't started yet or has ended already.");
}
/**
 * check if file uploaded or editor used
 * if editor then get the name of the file
 * if uploaded then verify that the uploaded file is of the type specified in question
 */
/**
 * get user id from session, and upload the file in the directory.
 */
/**
 * redirect to check compiling page.
 */
Auth::joinSession();
$quesName = $question->name;
// var_dump(Response::checkFileType($_FILES['code']['type']));
$username = $_SESSION['auth_username'];
// var_dump(Response::checkSize($_FILES['code']['size']));
$filename = $_FILES['code']['name'];
// var_dump(Response::checkExtension($_FILES['code']['name']));
$tmpName = $_FILES['code']['tmp_name'];
// var_dump(Response::checkError($_FILES['code']['error']));

if (isset($_FILES['code']['type']) && !empty($_FILES['code']['type'])){
	// echo "2";
	if (Response::checkFileType($_FILES['code']['type']) && Response::checkSize($_FILES['code']['size']) && Response::checkExtension($_FILES['code']['name']) && Response::checkError($_FILES['code']['error'])){
		//add validateFile function
		// echo "3";
		if (!mkdir("../Uploads/Question/".$quesName."/Response/".$username."/", 0777, true)) {
			// echo "4";
		    die('Failed to create folders...');
		}
		if(Response::submitResponse($quesName, $username, $filename, $tmpName)){
			echo "File uploaded Successfully";
			Response::compile($_GET['questionId'], $username, $filename);
			Response::execute($_GET['questionId'], $username, $filename);
			//header( "refresh:2;url=index.php" );
		}else{
			die("Something went wrong");
		}
		
	}
}

?>