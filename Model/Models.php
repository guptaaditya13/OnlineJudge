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
	public $questionText;
	public $questionImage;
	public $startTime;
	public $endTime;
	public $maxMarks;
	public $time;
	public $difficulty;
	public $tester;
	public $name;
	public function validateQuestionText($questionText)
	{
		$qText = htmlspecialchars(strip_tags($questionText));
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
	public function createNew($questionText, $questionImage, $startTime, $endTime, $maxMarks, $difficulty, $tester=null)
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
		// var_dump($qname);exit();
		$_SESSION['qname'] = $qname;
		$sql = "INSERT INTO `online_judge`.`questions` (`user_id`, `q_text`, `start_time`, ".
			"`end_time`, `max_marks`, `difficulty`, `timestamps`, `name`) VALUES ".
			"('$userID', '$questionText', '$startTime', '$endTime', '$maxMarks','$diff', CURRENT_TIMESTAMP, '$qname');";
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
		if ($this->questionText == NULL) {
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
		return createNew($this->userID,$this->questionId,$this->questionText,$this->questionImage,$this->startTime,$this->endTime,$this->maxMarks,$this->time,$this->difficulty);
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
			$temp->questionText = $row['q_text'];
			$temp->questionImage = $row['q_image'];
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
			$temp->questionText = $row['q_text'];
			$temp->questionImage = $row['q_image'];
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
			$var = $var && Delete('../Uploads/Question/' . $directoryName);
		}
		/**
		 * now creating the directory again
		 */
		return $var && mkdir('../Uploads/' . $directoryName , $mode) && mkdir('../Uploads/' . $directoryName . '/image' , $mode) && mkdir('../Uploads/' . $directoryName . '/sample' , $mode) && mkdir('../Uploads/' . $directoryName . '/test_case' , $mode) && mkdir('../Uploads/' . $directoryName . '/Response' , $mode);
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
	            Delete(realpath($path) . '/' . $file);
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
	public $question;
	public $student;
	public $address;

	/**
	 * @return Question
	 * 
	 * returns the question variable this response was associated with.
	 */
	public function getQuestion()
	{
		return Question::getQuestion($this->question);
	}
	/**
	 * @return Response
	 * 
	 * Creates a new entry in the databse, and also uploads the reponse to the directory.
	 */
	public function createNewResponse()
	{

	}
	/**
	 * @return String
	 * 
	 * Compiles the respose and returns the compile status, also makes the entry in the databse
	 */
	public function compile()
	{
		
	}

	/**
	 * @return String
	 * returns the current compile status of the file.
	 */
	public function compileStatus()
	{
		# code...
	}
}
?>