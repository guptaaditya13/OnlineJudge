<?php 
require ('../routes.php');
require ('../Model/Models.php');
Auth::logout();
header('Loaction:' . URL_LOGIN_PAGE);
// var_dump(URL_LOGIN_PAGE);
exit();
 ?>