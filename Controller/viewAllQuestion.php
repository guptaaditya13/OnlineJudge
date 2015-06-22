<?php 
require ('../routes.php');
require ('../Model/Models.php');
/**
 * retrieving data from db based on usertype.
 * $arr is the array containing objects of Question class.
 */
$arr = Question::getAll(Auth::loginStatus());
$dir = "../View/";
require($dir . 'Home.php');
?>