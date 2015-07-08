<?php 	
	exec("java ". __FILE__ ."../Resources/Compile sunny.java", $output);
	print_r($output);
	
 ?>
