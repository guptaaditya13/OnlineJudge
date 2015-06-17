<?php
require('../connection.php')
/**
* This Model is used to access the Login table for users.
*/
class Login
{
	public function getAll()
	{
		$sql = "SELECT * FROM login_table";
		$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
		$result = mysqli_query($sql,$conn);
		return $result;
	}

	public function get($id)
	{
		$sql = "SELECT * FROM login_table WHERE id = $id";
		$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
		$result = mysqli_query($sql,$conn);
		return $result;	
	}
	public function validateData($username, $password){

	}
}










?>