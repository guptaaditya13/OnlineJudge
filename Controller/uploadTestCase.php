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
 * If request carries POST parameters then process the data
 */
if (isset($_POST['sample']) && !empty($_POST['sample']) && is_numeric($_POST['sample'])) {
	/**
	 * Get the number of sample inputs that have already been uploaded
	 */
	$n = $question->getSampleInput();
	$fdir = '../Uploads/Question/' . $question->name . '/sample/';
	for ($i=1; $i <= $_POST['sample'] ; $i++) { 
		/**
		 * Check is that sample input is available or not
		 */
		if (isset($_POST["inp$i"]) && !empty($_POST["inp$i"]) && isset($_POST["out$i"]) && !empty($_POST["out$i"])) {
			/**
			 * if available then create a file for it.
			 */
			$n = $n + 1;
			$sample_inp = nl2br($_POST["inp$i"]);
			$sample_out = nl2br($_POST["out$i"]);
			$inpFile = fopen($fdir . "$n.txt", "w") or die("failed to create $n.txt the file");
			fwrite($inpFile, $sample_inp);
			fclose($inpFile);
			$outFile = fopen($fdir . "$n"."out.txt", "w") or die("failed to create $n"."out.txt the file");
			fwrite($outFile, $sample_out);
			fclose($outFile);	
		}
	}
	$question->setSampleInput($n);
	header('Location:' . URL_WEBSITE_HOME .'../viewQuestion.php?questionId='.$_GET['qno']);
	exit();
}
/**
 * If no request through POST then Server the upload question page.
 */
else {
	$dir ='../View/';
	require($dir . 'UploadTestCase.php');	
}
?>