<?php 
require ('../routes.php');
require ('../Model/Models.php');
session_start();
Auth::logout();
header('Loaction:' . URL_LOGIN_PAGE);
 ?>