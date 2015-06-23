<?php 
require ('../routes.php');
require ('../Model/Models.php');
Auth::logout();
header('Location:' . URL_WEBSITE_HOME);
 ?>