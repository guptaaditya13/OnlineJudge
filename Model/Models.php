<?php
require('../connection.php')
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
	// 	$sql = "SELECT * FROM login_table";
	// 	$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
	// 	$result = mysqli_query($sql,$conn);
	// 	mysqli_close($conn);
	// 	return $result;
	// }
	// *
	//  *@return array
	//  * This method returns an array containing the object with id = $id 
	
	// public function get($id)
	// {
	// 	$sql = "SELECT * FROM login_table WHERE id = $id";
	// 	$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
	// 	$result = mysqli_query($sql,$conn);
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
	 *@return instance of user(Student or Techer class)
	 * This method is used to get the user instance object, it also sets th data in the sessions.
	*/
	public function loginUser($username, $password){
		$sql = "SELECT * FROM login_table WHERE username = $username AND password = $password";
		$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
		$result = mysqli_query($sql,$conn);
		if (mysqli_num_rows($result) == 1){
			$row = mysqli_fetch_assoc($result);
			session_start();
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
	/**
	 *@return boolean
	 *This method inputs user's id, new password and password change token.
	 * If token is genuine, changes password and returns true
	 * else returns false 
	*/
	public function changePassword($id,$newpassword,$token)
	{
		$sql = "SELECT COUNT(*) FROM login_table WHERE id=$id AND token=$token";
		$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
		$result = mysqli_query($sql,$conn);
		$row = mysqli_fetch_assoc($result);
		$count = $row['COUNT(*)'];
		if($count == 1){
			$sql = "UPDATE TABLE login_table SET password = '$newpassword' WHERE id = $id";
			$result = mysqli_query($sql,$conn);
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
	 * Non-parameterized constructor of User class
	 */
	function __construct(){}

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
	 * Non parameterized constructor of Student class
	 */
	function __construct(){
		parent::__construct();
	}

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
	 * Non parameterized constructor of Teacher class
	 */
	function __construct(){
		parent::__construct();
	}

	/**
	 * @return instance of Teacher class
	 * 
	 * Parameterized constructor of Teacher class
	 */
	function __construct($name, $username, $id, $email){
		parent::__construct($name, $username, $id, $email);
	}
}
?>