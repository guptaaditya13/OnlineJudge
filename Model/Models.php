<?php
require('../connection.php');
//                                    AAA   UU   UU TTTTTTT HH   HH 
//                                   AAAAA  UU   UU   TTT   HH   HH 
//                                  AA   AA UU   UU   TTT   HHHHHHH 
//                                  AAAAAAA UU   UU   TTT   HH   HH 
//                                  AA   AA  UUUUU    TTT   HH   HH 
/**
* This Model is used to access the Login table for users.
*/
class Auth
{
	/**
	 *@return string
	 * This method checks whether the username is matched the regex or not. 
	*/
	public function validateData($username,$password){
		$error = null;
		if (strlen($username)<6 || strlen($username) > 40){
			$error = 'Username is too long or too short';
		} else if (!preg_match('/^[a-zA-Z0-9.]*$/', $username)) {
			$error = "Username of invalid pattern";
		} else if (strlen($password)<6 || strlen($password) > 20){
			$error = "Password is too short or too long";
		}
		return $error;
	}
	/**
	 *@return User class (Student or Techer class)
	 * This method is used to get the user instance object, it also sets the data in the sessions.
	*/
	public function loginUser($username, $password){
		$sql = "SELECT COUNT(*) FROM user_table WHERE username = '$username' AND password = '$password'";
		$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
		$result = mysqli_query($conn,$sql);
		$row = mysqli_fetch_assoc($result);
		// var_dump($row);exit();
		if ($row['COUNT(*)'] == 1){
			$sql = "SELECT * FROM user_table WHERE username = '$username'";
			$result = mysqli_query($conn,$sql);
			$row = mysqli_fetch_assoc($result);
			// var_dump($row);exit();
			$sql2 = "UPDATE user_table SET total_logins = total_logins + 1, last_login = CURTIME() WHERE id = " . $row['id']. ";";
			mysqli_query($conn,$sql2);
			Auth::joinSession();
			$_SESSION['auth_logged_in'] = True;
			$_SESSION['auth_username'] = $username;
			$_SESSION['auth_name'] = $row['name'];
			$_SESSION['auth_id'] = $row['id'];
			$_SESSION['auth_email'] = $row['email'];
			$_SESSION['auth_nick_name'] = $row['nick_name'];
			if ($row['type'] == 1){
				$_SESSION['auth_type'] = 'Teacher';
				$obj = new Teacher($row['name'],$row['username'],$row['id'],$row['email'],$row['nick_name']);
				mysqli_close($conn);
				return $obj;
			} else {
				$_SESSION['auth_type'] = 'Student';
				$obj = new Student($row['name'],$row['username'],$row['id'],$row['email'],$row['nick_name']);
				mysqli_close($conn);
				return $obj;
			}
		} else {
			mysqli_close($conn);
			return null;
		}
	}

	public function getCurrentUser()
	{
		Auth::joinSession();
		if (Auth::loginStatus()){
			$username = $_SESSION['auth_username'];
			$name = $_SESSION['auth_name'];
			$id = $_SESSION['auth_id'];
			$email = $_SESSION['auth_email'];
			$nickName = $_SESSION['auth_nick_name'];
			if ($_SESSION['auth_type'] == 'Teacher'){
				$obj = new Teacher($name,$username,$id,$email,$nickName);
			} else {
				$obj = new Student($name,$username,$id,$email,$nickName);
			}
			return $obj;
		} else {
			return null;
		}
	}
	public function getUser($id)
	{
		$sql = "SELECT * FROM user_table WHERE id = $id";
		$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
		$result = mysqli_query($conn,$sql);
		if ($result){
			$row = mysqli_fetch_assoc($result);
			$name = $row['name'];
			$username = $row['username'];
			$email = $row['email'];
			$nickName = $row['nick_name'];
			$clss;
			if ($row['type'] == 1){
				$clss = "Teacher";
			} else {
				$clss = "Student";
			}
			$obj = new $clss($name,$username,$id,$email,$nickName);
			return $obj;

		} else {
			return null;
		}
	}
	public function userType()
	{
		Auth::joinSession();
		if(isset($_SESSION['auth_type'])){
			return $_SESSION['auth_type'];
		} else {
			return null;
		}
	}

	/**
	 * @return String
	 * 
	 * This function returns user's class if logged in else returns null
	 */
	public function loginStatus()
	{
		Auth::joinSession();
		if(isset($_SESSION['auth_logged_in']) && $_SESSION['auth_logged_in'] == True){
			return $_SESSION['auth_type'];
		} else {
			return null;
		}
	}
	/**
	 *@return boolean
	 *This method inputs user's id, new password and password change token.
	 * If token is genuine, changes password and returns true
	 * else returns false 
	*/
	public function changePassword($id,$newpassword,$token)
	{
		$sql = "SELECT COUNT(*) FROM user_table WHERE id=$id AND token='$token'";
		$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
		$result = mysqli_query($conn,$sql);
		$row = mysqli_fetch_assoc($result);
		$count = $row['COUNT(*)'];
		if($count == 1){
			$sql = "UPDATE TABLE user_table SET password = '$newpassword' WHERE id = $id";
			$result = mysqli_query($conn,$sql);
			return true;
		} else{
			return false;
		}
	}

	/**
	 * Logout the current logged in user by destroying the session array.
	*/
	public function logout($value='')
	{
		Auth::joinSession();
		$_SESSION = array();
		session_destroy();
	}

	/**
	 * performs session_start() if a session is not already active.
	 */
	public function joinSession(){
		if (session_status() != PHP_SESSION_ACTIVE){
			session_start();
		}
	}

	/**
	 * @return String
	 * 
	 * Generates a random CSRF token of length 44. Does not put that in session array.
	 */
	public function generateCSRFtoken()
	{
		return base64_encode( openssl_random_pseudo_bytes(32));
	}

	/**
	 *  
	 * This function echo a String containing a HTML code of hidden input box with CSRF token
	 */
	public function embedCSRF()
	{
		$token = Auth::generateCSRFtoken();
		$_SESSION['CSRF'] = $token;
		echo "<input type = \"hidden\" name = \"CSRF\" value = \"$token\">";
	}

	/**
	 * @param boolean
	 * 
	 * Takes input the request method, checks whether the CSRF is valid or not.
	 */
	public function validateCSRF($requestMethod)
	{
		if (strcmp($requestMethod,"POST") == 0){
			return ((isset($_POST['CSRF'])) && (!empty($_POST['CSRF'])) && (strlen($_POST['CSRF']) == 44) && ($_SESSION['CSRF'] == $_POST['CSRF']));
		} elseif (strcmp($requestMethod,"GET") == 0) {
			return ((isset($_GET['CSRF'])) && (!empty($_GET['CSRF'])) && (strlen($_GET['CSRF']) == 44) && ($_SESSION['CSRF'] == $_POST['CSRF']));
		} else {
			return false;
		}
	}
}

//                                  UU   UU  SSSSS  EEEEEEE RRRRRR  
//                                  UU   UU SS      EE      RR   RR 
//                                  UU   UU  SSSSS  EEEEE   RRRRRR  
//                                  UU   UU      SS EE      RR  RR  
//                                   UUUUU   SSSSS  EEEEEEE RR   RR 
/**
* The basic parent class of child Student and Techer
*/
class User
{
	var $name;
	var $username;
	var $id;
	var $email;
	var $nickName;
	/**
	 * @return instance of User class
	 * 
	 * Parameterized constructor of User class
	 */
	function __construct($name, $username, $id, $email, $nickName)
	{
		$this->name = $name;
		$this->username = $username;
		$this->id = $id;
		$this->email = $email;
		$this->nickName = $nickName;
	}
}


//                       SSSSS  TTTTTTT UU   UU DDDDD   EEEEEEE NN   NN TTTTTTT 
//                      SS        TTT   UU   UU DD  DD  EE      NNN  NN   TTT   
//                       SSSSS    TTT   UU   UU DD   DD EEEEE   NN N NN   TTT   
//                           SS   TTT   UU   UU DD   DD EE      NN  NNN   TTT   
//                       SSSSS    TTT    UUUUU  DDDDDD  EEEEEEE NN   NN   TTT   

/**
* The student class contains all methods and properties related to Student
*/
class Student extends User
{

	/**
	 * @return instance of Student class
	 * 
	 * Parameterized constructor of Student class
	 */
	function __construct($name, $username, $id, $email, $nickName){
		parent::__construct($name, $username, $id, $email, $nickName);
	}
}

//                      TTTTTTT EEEEEEE   AAA    CCCCC  HH   HH EEEEEEE RRRRRR  
//                        TTT   EE       AAAAA  CC    C HH   HH EE      RR   RR 
//                        TTT   EEEEE   AA   AA CC      HHHHHHH EEEEE   RRRRRR  
//                        TTT   EE      AAAAAAA CC    C HH   HH EE      RR  RR  
//                        TTT   EEEEEEE AA   AA  CCCCC  HH   HH EEEEEEE RR   RR 
/**
* The teacher class contains all methods and properties related to Student
*/
class Teacher extends User
{
	/**
	 * @return instance of Teacher class
	 * 
	 * Parameterized constructor of Teacher class
	 */
	function __construct($name, $username, $id, $email, $nickName){
		parent::__construct($name, $username, $id, $email, $nickName);
	}
}

//                    QQQQQ  UU   UU EEEEEEE  SSSSS  TTTTTTT IIIII  OOOOO  NN   NN 
//                   QQ   QQ UU   UU EE      SS        TTT    III  OO   OO NNN  NN 
//                   QQ   QQ UU   UU EEEEE    SSSSS    TTT    III  OO   OO NN N NN 
//                   QQ  QQ  UU   UU EE           SS   TTT    III  OO   OO NN  NNN 
//                    QQQQ Q  UUUUU  EEEEEEE  SSSSS    TTT   IIIII  OOOO0  NN   NN 

/**
* Following class will represent a question in the database.
*/
class Question
{
	public $userID;
	public $questionId;
	public $questionTitle;
	public $questionText;
	public $startTime;
	public $endTime;
	public $maxMarks;
	public $time;
	public $difficulty;
	public $tester;
	public $name;
	public function validateQuestionText($questionText)
	{
		$qText = htmlspecialchars($questionText);
		$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
		$qText = mysqli_real_escape_string($conn,$qText);
		return $qText;
	}
	public function validateTime($time)
	{
//		if (preg_match('/^(\\d\\d)-(\\d\\d)-(\\d\\d\\d\\d) (\\d\\d):(\\d\\d) ([AP]M)$/',$time,$arr)){
//			return $arr[3] ."-" .$arr[2]."-".$arr[1] . " " . $arr[4] . ":" . $arr[5] . ":00" . " " . $arr[6];
//		}
        $format = "Y-m-d?h:i A";
        $obj = DateTime::createFromFormat($format, $time);
        if ($obj){
            return $obj;
        } else {
            $format = "Y-m-d?H:i";
            $obj = DateTime::createFromFormat($format, $time);
            return $obj;
        }
	}
    public function validateDates($startDate,$endDate){
        return $startDate < $endDate;
    }
	/**
	 * @return boolean
	 * validateQuestionId($id) is used to check if the question id is of valid type or not.
	 * This method will allow developers to adopt a generic id for the questions
	 */
	public function validateQuestionId($id)
	{
		return is_numeric($id);
	}

	public function ifExist($id)
	{
		$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
		$sql = "SELECT COUNT(*) FROM `questions` WHERE id = $id";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		return $row['COUNT(*)'] == 1;
	}

	/**
	 * @return boolean
	 * createNew(...) creates an entry in the table questions. If successful returns TRUE else returns FALSE
	 */
	public function createNew($questionTitle, $question, $startTime, $endTime, $maxMarks, $difficulty, $tester=null, $upload, $arr)
	{
		Auth::joinSession();
		$diff = 0;
		$userID = $_SESSION['auth_id'];
		if ($difficulty == "easy"){
			$diff = 0;
		}elseif ($difficulty == "medium") {
			$diff = 1;
		}elseif ($difficulty == "hard") {
			$diff = 2;
		}else{
			$diff = 3;
		}
		$sql = "SELECT COUNT(*) FROM questions WHERE user_id = $userID;";
		// var_dump($sql);
		$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
		$result = mysqli_query($conn,$sql);
		$row = mysqli_fetch_assoc($result);
		$count = $row['COUNT(*)'] + 1;
		$qname = $_SESSION['auth_nick_name'] .'_'. $count;
		if(Question::createDirectoryForQuestion($qname, 0777)){
		} else {
			return false;
		}
		if(!$upload){
			$dir = "../Uploads/Question/$qname/image/";
			if($arr){
				for ($i=0; $i < count($_FILES['fileToUpload']['name']); $i++) { 
					if (Question::addImageToText(basename($_FILES["fileToUpload"]["name"][$i]),$dir, $question) && Question::uploadImage($_FILES["fileToUpload"]["tmp_name"][$i],$dir.basename($_FILES["fileToUpload"]["name"][$i]))){

					} else {
						return false;
					}
				}
			} else {
				if (Question::addImageToText(basename($_FILES["fileToUpload"]["name"]),$dir, $question) && Question::uploadImage($_FILES["fileToUpload"]["tmp_name"],$dir.basename($_FILES["fileToUpload"]["name"]))){

				} else {
					return false;
				}
			}
		}
		$questionText=Question::validateQuestionText($questionText);
		$sql = "INSERT INTO `online_judge`.`questions` (`user_id`,`q_title` ,`q_text`, `start_time`, ".
			"`end_time`, `max_marks`, `difficulty`, `timestamps`, `name`) VALUES ".
			"('$userID', '$questionTitle','$question', '$startTime', '$endTime', '$maxMarks','$diff', CURRENT_TIMESTAMP, '$qname');";
		// var_dump($sql);
		$result = mysqli_query($conn,$sql);
		if ($result == true){
			return true;
	
		} else {
			return false;
		}
	}
	/**
	 * @return boolean
	 * 
	 * saves the 
	 */
	public function save()
	{
		if ($this->userID == NULL) {
			return FALSE;
		}
		if ($this->questionTitle == NULL) {
			return FALSE;
		}
		if ($this->maxMarks == NULL) {
			$this->maxMarks = 0;
		}
		if ($this->time == NULL) {
			$time = time() + (5*60*60 + 30*60);
            $stime = gmdate('Y-m-d H:i:s',$time);	
			$this->time = $stime;
		}
		if ($this->difficulty == NULL) {
			$this->difficulty = 0;
		}
		return createNew($this->userID,$this->questionId,$this->questionTitle,$this->questionImage,$this->startTime,$this->endTime,$this->maxMarks,$this->time,$this->difficulty);
	}

	/**
	 * @return array
	 * returns all the questions available in the database according to the type of user
	 * example : 
	 * 1. If requested by student, it will only show questions whose submission is going on, or completed
	 * 2. If requested by faculty, it will show all the questions present in the database.
	 */
	public function getAll($userType, $limit)
	{
		$sql = "";
		if ($userType == "Teacher"){
			$sql = "SELECT * FROM `questions`";
		} elseif ($userType == "Student") {
			$sql = "SELECT * FROM `questions` WHERE `start_time` <= CURTIME()";
		} else {
			$sql = "SELECT * FROM `questions` WHERE `start_time` <= CURTIME()";
		}
		if ($limit != 0){
			$sql.= " LIMIT $limit;";
		}
		$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
		$result = mysqli_query($conn,$sql);
		// var_dump($sql);echo("<br>");
		// var_dump($result);echo("<br>");
		$n = mysqli_num_rows($result);
		$res = array();
		for ($i=0; $i <$n ; $i++) { 
			$row = mysqli_fetch_assoc($result);
			$temp = new Question();
			$temp->userID = $row['user_id'];
			$temp->questionId = $row['id'];
			$temp->questionTitle = $row['q_title'];
			$temp->questionText = $row['q_text'];
			$temp->startTime = $row['start_time'];
			$temp->endTime = $row['end_time'];
			$temp->maxMarks = $row['max_marks'];
			$temp->time = $row['timestamps'];
			$temp->difficulty = $row['difficulty'];
			$temp->tester = $row['tester'];
			$temp->name = $row['name'];
			$res[] = $temp;
		}
		return $res;
	}
	/**
	 * @return Question instance
	 * 
	 * Takes question Id as input and returns the question object.
	 */
	public function getQuestion($questionId)
	{
		$sql = "SELECT * FROM questions WHERE id = $questionId;";
		$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
		$result = mysqli_query($conn,$sql);
		$n = mysqli_num_rows($result);
		$temp;
		if ($n == 1) { 
			$row = mysqli_fetch_assoc($result);
			$temp = new Question();
			$temp->userID = $row['user_id'];
			$temp->questionId = $row['id'];
			$temp->questionTitle = $row['q_title'];
			$temp->questionText = $row['q_text'];
			$temp->startTime = $row['start_time'];
			$temp->endTime = $row['end_time'];
			$temp->maxMarks = $row['max_marks'];
			$temp->time = $row['timestamps'];
			$temp->tester = $row['tester'];
			$temp->name = $row['name'];
			$difficulty = $row['difficulty'];
			if ($difficulty == 0){
				$temp->difficulty = "Easy";
			} elseif ($difficulty == 1){
				$temp->difficulty = "Medium";
			} elseif ($difficulty == 2){
				$temp->difficulty = "Hard";
			} else {
				$temp->difficulty = "Challenge";
			}
		}
		mysqli_close($conn);
		return $temp;
	}

	/**
	 * get total number of input test cases for compiling and running
	 */
	public function getTotalNum($questionId ,$inputType){
		$sql = "SELECT * FROM questions WHERE id = $questionId;";
		$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
		$result = mysqli_query($conn,$sql);
		$n = mysqli_num_rows($result);
		if ($n == 1) { 
			$row = mysqli_fetch_assoc($result);
			if ($inputType == "sample"){
				return $row['sample_inp'];
			}
			else{
				return $row['test_case'];
			}
		}
	}



	public function editQuestion($questionId ,$q_text, $q_image, $start_time, $end_time, $max_marks, $difficulty, $tester = NULL){
		if ($difficulty == 0){
				$temp->difficulty = "Easy";
			} elseif ($difficulty == 1){
				$temp->difficulty = "Medium";
			} elseif ($difficulty == 2){
				$temp->difficulty = "Hard";
			} else {
				$temp->difficulty = "Challenge";
			}
		$sql = "UPDATE `questions` SET `q_text`=$q_text,`q_image`=$q_image,`start_time`=$start_time,`end_time`=$end_time,`max_marks`=$max_marks,`difficulty`=$diff,`tester`=$tester WHERE id = $questionId;";
		$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
		$result = mysqli_query($conn,$sql);
	}
	/**
	 * @return boolean
	 * @param int
	 * 
	 * Checks whether the current time lies between the start and end time of the question
	 * 	 */
	public function isActive($questionId){
		$question = Question::getQuestion($questionId);
		if ((time() >= (strtotime($question->startTime))) && (time() <= strtotime($question->endTime))){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	/**
	 * changes the start time of the question to given time.
	 */
	public function startQuestion($questionId, $time)
	{
		$sql = "UPDATE questions SET start_time = $time WHERE id = $questionId";
		$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
		$result = mysqli_query($conn,$sql);
	}

	/**
	 * changes the end time of the question to given time.
	 */
	public function endQuestion($questionId, $time)
	{
		$sql = "UPDATE questions SET end_time = $time WHERE id = $questionId";
		$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
		$result = mysqli_query($conn,$sql);
	}

	/**
	 * @return boolean
	 * 
	 * if userId given is listed in either question's userId or in question's tester's id then the user has access to question.
	 */
	public function checkAccess($userId)
	{
		if($this->userID == $userId){
			return true;
		}
		if ($this->tester) {
			$testers = explode(",",$this->tester);
            foreach($testers as $x){
                if ($x == $userId){
                    return true;
                }
            }
		}
        return false;
	}
	/**
	 * @return String
	 * 
	 * returns null if everything is perfect else returns the error.
	 */
	public function checkImageAttachment($file_name, $file_type, $file_tmp_name, $file_error, $file_size)
	{
		if($var = Question::verifyUploadedImage($file_tmp_name)){
			return $var;
		}
		if ($var = Question::checkFileSize($file_size)) {
			return $var;
		}
		$target_file = basename($file_name);
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		if ($var = Question::checkFileFormat($imageFileType)){
			return $var;
		}
		return null;
	}
	/**
	 * @return String
	 * 
	 * Formats the text to add support for the image.
	 */
	public function addImageToText($imageName,$dir, $questionText)
	{
		// var_dump($imageName); echo "<br>";
		// var_dump($dir); echo "<br>";
		// var_dump($questionText); echo "<br>";
		// exit();
		$img = preg_replace("/./","\\.",$imageName);
		$re = "/<img\\ src=\"[A-Za-z0-9:_\\s\\\\\\/,`~!@#$%^&*\\(\\)-=+|\\[\\]\\{\\}]*\\\\" . $img . "\"\\ alt=\"[\\w\\s]*\"\\ \\/>/";
		/** Add alternate text later*/
		$replacement = '<img src="'.$dir.$imageName.'">';
		return preg_replace($re, $replacement , $questionText);
	}

	/**
	 * @return String
	 * 
	 * argument1 is $_FILE["fileToUpload"]["tmp_name"]
	 * i.e. temporary address of the file.
	 */
	public function verifyUploadedImage($tempName)
	{
		$check = getimagesize($tempName);
    	if($check !== false) {
    		return null;
    	} else {
	        return "File not an image";
	    }
	}
	/**
	 * @return String
	 * 
	 * parameter 1 is $_FILES["fileToUpload"]["size"]
	 */
	public function checkFileSize($file)
	{
		if ($file > 5242880) {
			return "File is larger than 5 MB";
		}
		return null;
	}
	/**
	 * @return String
	 * 
	 * parameter 1 is $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	 * $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	 */
	public function checkFileFormat($imageFileType)
	{
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    	
    	return "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    	}

    	return null;
	}

	/**
	 * @return boolean
	 * 
	 * first parameter is $_FILES['fileToUpload']['tmp_name']
	 */
	public function uploadImage($file_temp_name,$target_file)
	{
		if (move_uploaded_file($file_temp_name, $target_file)) {
	        return true;
	    } else {
	        return false;
	    }
	}

	/**
	 * @return boolean
	 * 
	 * This function creates the directory structure for the question and return true on success
	 */
	public function createDirectoryForQuestion($directoryName, $mode)
	{	
		$var = true;
		/**
		 * check if that directory already exists
		 */
		if(file_exists('../Uploads/Question/' . $directoryName)){
			clearstatcache();
			/**
			 * As directory exists, recursively deleting the directory
			 */
			$var = $var && Question::Delete('../Uploads/Question/' . $directoryName);
		}
		/**
		 * now creating the directory again
		 */
		return $var && mkdir('../Uploads/Question/' . $directoryName , $mode) && mkdir('../Uploads/Question/' . $directoryName . '/image' , $mode) && mkdir('../Uploads/Question/' . $directoryName . '/sample' , $mode) && mkdir('../Uploads/Question/' . $directoryName . '/test_case' , $mode) && mkdir('../Uploads/Question/' . $directoryName . '/Response' , $mode);
	}


	/**
	 * @return bool
	 * 
	 * Deletes the file/directory whose path is given
	 */
	function Delete($path){
	    if (is_dir($path)){
	        $files = array_diff(scandir($path), array('.', '..'));

	        foreach ($files as $file){
	            Question::Delete(realpath($path) . '/' . $file);
	        }

	        return rmdir($path);
	    }

	    else if (is_file($path)){
	        return unlink($path);
	    }

	    return false;
	}
	/**
	 * @return int
	 * returns total sample input for the question
	 */
	public function getSampleInput()
	{
		$id = $this->questionId;
		$sql = "SELECT sample_inp FROM questions WHERE id = $id";
		$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
		$result = mysqli_query($conn,$sql);
		$row = mysqli_fetch_assoc($result);
		return $row['sample_inp'];
	}
	/**
	 * @return void
	 * sets the sample_input value in database table to new value
	 */
	public function setSampleInput($newSI)
	{
		$id = $this->questionId;
		$sql = "UPDATE questions SET sample_inp = $newSI WHERE id = $id";
		$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
		$result = mysqli_query($conn,$sql);
	}
	/**
	 * @return int
	 * returns total test cases for the question
	 */
	public function getTestCase()
	{
		$id = $this->questionId;
		$sql = "SELECT test_case FROM questions WHERE id = $id";
		$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
		$result = mysqli_query($conn,$sql);
		$row = mysqli_fetch_assoc($result);
		return $row['test_case'];
	}
	/**
	 * @return void
	 * sets the test_case value in database table to new value
	 */
	public function setTestCase($newSI)
	{
		$id = $this->questionId;
		$sql = "UPDATE questions SET test_case = $newSI WHERE id = $id";
		$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
		$result = mysqli_query($conn,$sql);
	}

}


//                      RRRRRR  EEEEEEE  SSSSS  PPPPPP   OOOOO  NN   NN  SSSSS  EEEEEEE 
//                      RR   RR EE      SS      PP   PP OO   OO NNN  NN SS      EE      
//                      RRRRRR  EEEEE    SSSSS  PPPPPP  OO   OO NN N NN  SSSSS  EEEEE   
//                      RR  RR  EE           SS PP      OO   OO NN  NNN      SS EE      
//                      RR   RR EEEEEEE  SSSSS  PP       OOOO0  NN   NN  SSSSS  EEEEEEE 

/**
 * This class is for the response code submitted to a question
 */
 class Response
 {
 	
 	public $responseId;
 	public $questionId;
 	public $student;
 	public $address;
	
	/**
	 * @return Question
	 * 
	 * returns the question variable with which the reposnse is associated
	 */
 	public function getQuestion(){
 		return Question::getQuestion($this->questionId);
 	}

 	/**
 	 * @return Compile status
 	 * This function will be called at two situation.. One from the testing the sample test cases
 	 * else testing all test cases.
 	 * This function will compile the response(program) of the user
 	 */
 	public function compile($questionId, $username, $filename){
 		$question = Question::getQuestion($questionId);
 		$quesName = $question->name;
 		$file = explode(".", $filename);
 		chdir("../Resources");
 		$codeAdd = "../Uploads/Question/".$quesName."/Response/".$username."/".$file[0].".java"; 
 		exec("java Compile ".$codeAdd, $output);
		print_r($output);
		//delete the file if compilation error
 	}

 	/**
 	 * @return Execute status
 	 * This function will be called at two situation.. One from the testing the sample test cases
 	 * else testing all test cases.
 	 * This function will return the execution status.
 	 *
 	 * filename should be without extension
 	 * username is required
 	 * totalNum will take the number of test cases.
 	 */
 	public function execute($questionId, $username, $filename, $totalNum){
 		$question = Question::getQuestion($questionId);
 		$quesName = $question->name;
 		$file = explode(".", $filename);
 		
 		$codeAdd = "../Uploads/Question/".$quesName."/Response/".$username."/".$file[0].".class";
 		chdir("../Resources");
 		if (file_exists($codeAdd)){
 			for ($i=1; $i <= $totalNum; $i++) { 
 				exec("java Execute ". $file[0] . " " . $quesName . " ". $username ." ". $i, $output);
 			}
 			// exec("java Execute ". $file[0] . " " . $quesName . " ". $username ." 1" , $output);
 			// foreach ($output as $x) {
 			// 	echo $x."<br>";
 			// }
 			// print_r($output); //it's printing the whole array....we don't want this
 			return true;
 		}
 		return false;
 	}

 	/**
 	 * @return Response
 	 *
 	 * Creates a new entry to the in the database
 	 */
 	public function createResponse($questionId, $studId, $fileAdd, $compileStat, $sample_inp){
 		$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
 		$sql = "INSERT INTO `response`(`question_id`, `stud_id`, `file_address`, `compile_status`, `sample_inputs`, `timestamps`) VALUES ('$questionId','$studId','$fileAdd','$compileStat','$sample_inp', CURRENT_TIMESTAMP)";
 		$result = mysqli_query($conn,$sql);
		// var_dump($sql);
		if ($result == true){
			return true;
			
 		}else{
 			return false;
 		}
 	}

 	/**
 	 * Check if the file is java type
 	 */
 	public function checkFileType($fileType){
 		if ($fileType == "application/octet-stream"){
 			return true;
 		}else{
 			return false;
 		}
 	}

 	/**
 	 * Check if file size is less than 100KB
 	 */
 	public function checkSize($fileSize){
 		if ($fileSize < 102400){
 			return true;
 		}else{
 			return false;
 		}
 	}

 	/**
 	 * Checking if the extension is java
 	 */
 	public function checkExtension($fileName){
 		$extName = explode(".", $fileName);
 		$extension = end($extName);
 		if ($extension == "java"){
 			return true;
 		}else{
 			return false;
 		}
 	}

 	/**
 	 * @return true if no error
 	 * check if there is error in file
 	 */
 	public function checkError($error){
 		if ($error == 0){
 			return true;
 		}else{
 			return false;
 		}
 	}

 	/**
 	 * Validate file name
 	 */
 	public function validateFile(){

 	}
 	
 	/**
 	 * store the file to its location
 	 */
 	public function submitResponse($quesName, $username, $filename, $tmpName ){
 		$dir = "../Uploads/Question/".$quesName."/Response/".$username;
		$error = true;
		$filename = $_FILES['code']['name'];
		$tmpName = $_FILES['code']['tmp_name'];
		if(move_uploaded_file($tmpName, $dir . "/" . $filename)){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * @return true if both file matches.
	 * Check if the program submitted prodeuced the desired output
	 */
	public function compareFiles($givenOut, $generOut){
        $fp_a = fopen($givenOut, 'r');
        $fp_b = fopen($generOut, 'r');
        // readfile($givenOut);
        // echo "<BR>";
        // readfile($generOut);
        // var_dump($givenOut);
        // var_dump($generOut);
		$match=true;
		if ($fp_a && $fp_b) {
    		while (($line1 = fgets($fp_a)) !== false) {
        		if(($line2 = fgets($fp_b)) !== false){
        			// var_dump($line1);echo"--";
        			// var_dump($line2);
        			// echo"<br>";
        			if ($line1 != $line2){

        				$match = false;
        				break;
        			}
    			}else{
    				$match = false;
    				break;
    			}
        	}
   		}
   		fclose($fp_a);
   		fclose($fp_b);
   		if ($match){
   			return true;
   		}else{
   			return false;
   		}
	}
}	
?>
