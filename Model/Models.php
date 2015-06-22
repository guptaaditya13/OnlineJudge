<?php
require('../connection.php');
/**
* This Model is used to access the Login table for users.
*/
class Auth
{
	// /**
	//  *@return array.
	//  * This method returns all the data present in the login table.
	// */
	// public function getAll()
	// {
	// 	$sql = "SELECT * FROM user_table";
	// 	$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
	// 	$result = mysqli_query($conn,$sql);
	// 	mysqli_close($conn);
	// 	return $result;
	// }
	// *
	//  *@return array
	//  * This method returns an array containing the object with id = $id 
	
	// public function get($id)
	// {
	// 	$sql = "SELECT * FROM user_table WHERE id = $id";
	// 	$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
	// 	$result = mysqli_query($conn,$sql);
	// 	mysqli_close($conn);
	// 	return $result;	
	// }
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
			session_start();
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
		session_start();
		// var_dump($_SESSION);
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
	var $userID;
	var $questionId;
	var $questionText;
	var $questionImage;
	var $startTime;
	var $endTime;
	var $maxMarks;
	var $time;
	var $difficulty;
	// function __construct(argument)
	// {
	// 	# code...
	// }
	public function createNew($questionText, $questionImage, $startTime, $endTime, $maxMarks, $difficulty)
	{
		$has_session = session_status() == PHP_SESSION_ACTIVE;
		if (!$has_session){
			session_start();
		}
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
			"('$userID', '$questionText', '$start_time', '$endTime', '$maxMarks','$diff' CURRENT_TIMESTAMP);";
		$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
		$result = mysqli_query($conn,$sql);
		if ($result == true){
			return true;
		} else {
			return false;
		}
	}

	public function getAll($value='')
	{
		$sql = "SELECT * FROM questions;";
		$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
		$result = mysqli_query($conn,$sql);
		$n = mysqli_num_rows($result);
		$res = array();
		for ($i=0; $i <$n ; $i++) { 
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
			$res[] = $temp;
		}
		return $res;
	}
}
?>