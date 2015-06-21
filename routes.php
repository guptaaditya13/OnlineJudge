<?php
define('DIR_SERVER', '/OnlineJudge/');
define('ROUTE_VIEW', $_SERVER['HTTP_HOST'] . DIR_SERVER . '/View/');
define('ROUTE_MODEL', $_SERVER['HTTP_HOST'] . DIR_SERVER . '/Model/');
define('ROUTE_CONTROLLER', $_SERVER['HTTP_HOST'] . DIR_SERVER . '/Controller/');
echo ROUTE_VIEW;
?>