<?php 
require('../connection.php');
$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);

$sql = "SELECT * FROM login_table";
$result = mysqli_query($conn,$sql);
var_dump($result);
 ?>