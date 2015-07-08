<?php 	
	// $x = explode("/", "".__FILE__."");
	// var_dump($x);
	// $address =$x[0];

	// for ($i=1; $i < sizeof($x)-2; $i++) { 
	// 	$address.= "/".$x[$i];
	// }
	// $path = $address . '/Resources/';
	// var_dump($path);
	// exec("java Compile sunny.java", $output);
	// print_r($output);\
	chdir("../Resources");
	exec("java Compile sunny.java", $output);
	print_r($output);
 ?>
