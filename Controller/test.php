<?php 
	// echo "123";
	// print_r($_POST);
	// print_r($_FILES['code']);
	// echo $_POST["submit"];
	
	// $_FILES["code"]["type"];
	// mkdir("../Uploads/Question/money/", 0777, true);
	require ('../routes.php');
	require ('../Model/Models.php');
	// $fp_a = fopen('../Uploads/Question/samrat_10/Response/sunny.cs13/sample/2out.txt', 'r');

	// $fp_b = fopen('../Uploads/Question/samrat_10/sample/2out.txt', 'r');
	// // var_dump($fp_a);
	// var_dump($fp_b);
	
	var_dump(Response::compareFiles('../Uploads/Question/samrat_10/sample/1out.txt', '../Uploads/Question/samrat_10/Response/sunny.cs13/sample/1out.txt'));
 ?>