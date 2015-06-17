<?php
require('../connection.php')
/**
* This Model is used to access the Login table for users.
*/
class Login
{
	/**
	 *@return array.
	 * This method returns all the data present in the login table.
	*/
	public function getAll()
	{
		$sql = "SELECT * FROM login_table";
		$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
		$result = mysqli_query($sql,$conn);
		mysqli_close($conn);
		return $result;
	}
	/**
	 *@return array
	 * This method returns an array containing the object with id = $id 
	*/
	public function get($id)
	{
		$sql = "SELECT * FROM login_table WHERE id = $id";
		$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
		$result = mysqli_query($sql,$conn);
		mysqli_close($conn);
		return $result;	
	}
	/**
	 *@return string
	 * This method checks whether the username is matched the regex or not. 
	*/
	public function validateData($username, $password){
		$error = null;
		if (!preg_match('/^[a-zA-Z0-9.]*$/', $username)) {
			$error = "username of invalid pattern";
		}
		return $error;
	}
	/**
	 *@return array containg user information
	 * This method is used to get the user information from its username and password.
	*/
	public function getUser($username, $password){
		$sql = "SELECT * FROM login_table WHERE username = $username AND password = $password";
		$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
		$result = mysqli_query($sql,$conn);
		if (mysqli_num_rows($result) == 1){
			mysqli_close($conn);
			return $result;
		} else {
			mysqli_close($conn);
			return null;
		}
	}
}
?>