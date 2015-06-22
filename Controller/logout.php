<?php 
require ('../routes.php');
require ('../Model/Models.php');
session_start();
Auth::logout();
$dir = '../View/';
require($dir . 'Home.php');
 ?>