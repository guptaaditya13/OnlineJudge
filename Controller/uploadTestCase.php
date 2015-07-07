<?php 
require ('../routes.php');
require ('../Model/Models.php');
/**
 * Verify if user is logged in or not.
 * Logged in user should be of Teacher type.
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
 * Check if data is set in GET array or not.
 */
$question = null;
if (isset($_GET['qno']) && !empty($_GET['qno']) && Question::validateQuestionId($_GET['qno']) && Question::ifExist($_GET['qno'])) {
	$question = Question::getQuestion($_GET['qno']);
} else {
	die("Improper request parameter.");
}
/**
 * Check if user requesting the page has access to upload test case for this question or not.
 */
if (!$question->checkAccess($_SESSION['auth_id'])){
	die("You don't have access to upload testcases for this question");
}
/**
 * Server the upload question page.
 */
if (isset($_POST['sample']) && !empty($_POST['sample']) && is_numeric($_POST['sample'])) {
	$sample_inp1 = nl2br($_POST['inp1']);
	$sample_out1 = nl2br($_POST['out1']);
}
$dir ='../View/';
require($dir . 'UploadTestCase.php');
?>