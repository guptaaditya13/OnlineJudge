<?php
require('../connection.php');
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
	 * This method is used to get the user instance object, it also sets th data in the sessions.
	*/
	public function loginUser($username, $password){
		$sql = "SELECT * FROM user_table WHERE username = '$username' AND password = '$password'";
		// var_dump($sql);
		$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
		$result = mysqli_query($conn,$sql);
		if ($result != null){
			$row = mysqli_fetch_assoc($result);
			Auth::joinSession();
			$_SESSION['auth_logged_in'] = True;
			$_SESSION['auth_username'] = $username;
			$_SESSION['auth_name'] = $row['name'];
			$_SESSION['auth_id'] = $row['id'];
			$_SESSION['auth_email'] = $row['email'];
			if ($row['type'] == 1){
				$_SESSION['auth_type'] = 'Teacher';
				$obj = new Teacher($row['name'],$row['username'],$row['id'],$row['email']);
				mysqli_close($conn);
				return $obj;
			} else {
				$_SESSION['auth_type'] = 'Student';
				$obj = new Student($row['name'],$row['username'],$row['id'],$row['email']);
				mysqli_close($conn);
				return $obj;
			}
		} else {
			mysqli_close($conn);
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

	public function logout($value='')
	{
		Auth::joinSession();
		$_SESSION = array();
		session_destroy();
	}
	public function joinSession(){
		if (session_status() != PHP_SESSION_ACTIVE){
			session_start();
		}
	}

}
/**
* The basic parent class of child Student and Techer
*/
class User
{
	var $name;
	var $username;
	var $id;
	var $email;

	/**
	 * @return instance of User class
	 * 
	 * Parameterized constructor of User class
	 */
	function __construct($name, $username, $id, $email)
	{
		$this->$name = $name;
		$this->username = $username;
		$this->$id = $id;
		$this->$email = $email;
	}
}

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
	function __construct($name, $username, $id, $email){
		parent::__construct($name, $username, $id, $email);
	}
}
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
	function __construct($name, $username, $id, $email){
		parent::__construct($name, $username, $id, $email);
	}
}

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
	function __construct()
	{
		# code...
	}
	
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
        $format = "m-d-Y h:i A";
        $obj = DateTime::createFromFormat($format, $time);
        if ($obj){
            return $obj;
        } else {
            $format = "m-d-Y H:i";
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
	/**
	 * @return boolean
	 * createNew(...) creates an entry in the table questions. If successful returns TRUE else returns FALSE
	 */
	public function createNew($questionText, $questionImage, $startTime, $endTime, $maxMarks, $difficulty)
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
		$sql = "INSERT INTO `online_judge`.`questions` (`user_id`, `q_text`, `start_time`, ".
			"`end_time`, `max_marks`, `difficulty`, `timestamps`) VALUES ".
			"('$userID', '$questionText', '$startTime', '$endTime', '$maxMarks','$diff', CURRENT_TIMESTAMP);";
		// var_dump($sql);
		$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
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
		if ($this->$userID == NULL) {
			return FALSE;
		}
		if ($this->$questionText == NULL) {
			return FALSE;
		}
		if ($this->$maxMarks == NULL) {
			$this->$maxMarks = 0;
		}
		if ($this->$time == NULL) {
			$time = time() + (5*60*60 + 30*60);
            $stime = gmdate('Y-m-d H:i:s',$time);	
			$this->$time = $stime;
		}
		if ($this->$difficulty == NULL) {
			$this->$difficulty = 0;
		}
		return createNew($this->$userID,$this->$questionId,$this->$questionText,$this->$questionImage,$this->$startTime,$this->$endTime,$this->$maxMarks,$this->$time,$this->$difficulty);
	}
	/**
	 * @return Question array
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
		// } elseif ($userType == "Student") {
			// $sql = "SELECT * FROM `questions` WHERE `start_time` <= CURTIME()";
		} else {
			$sql = "SELECT * FROM `questions` WHERE `start_time` <= CURTIME()"; //
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
			// var_dump($row);echo("<br>");
			$temp = new Question();
			$temp->userID = $row['user_id'];
			$temp->questionId = $row['id'];
			$temp->questionText = $row['q_text'];
			$temp->questionImage = $row['q_image'];
			$temp->startTime = $row['start_time'];
			$temp->endTime = $row['end_time'];
			$temp->maxMarks = $row['max_marks'];
			$temp->time = $row['timestamps'];
			// $temp->difficulty = $row['difficulty'];
			$res[] = $temp;
		}
		return $res;
	}
	/**
	 * 
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
			$temp->$userID = $row['user_id'];
			$temp->$questionId = $row['id'];
			$temp->$questionText = $row['q_text'];
			$temp->$questionImage = $row['q_image'];
			$temp->$startTime = $row['start_time'];
			$temp->$endTime = $row['end_time'];
			$temp->$maxMarks = $row['max_marks'];
			$temp->$time = $row['timestamps'];
			$temp->difficulty = $row['difficulty'];
		}
		return $temp;
	}

}
?>