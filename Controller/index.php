<?php
require ('../Model/Models.php');
if($type = Auth::loginStatus()){
	$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . $type . 'Home.php';
	header('Location: ' . $home_url);
	exit();
} else {
	require('../View/Home.html');
}
?>