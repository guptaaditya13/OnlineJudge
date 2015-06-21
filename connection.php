<?php 
/**
 * Enter the database connection details in this file.
 * Current version is only compatible with using MySQL as database.
 * Important points:
 * 1. First create the database then enter the connection details.
 * 2. After filling the connection details run file migrations/setupdb.php to setup the database.
 */

if (defined('SERVER_ADDRESS')) {} else {
	define ('SERVER_ADDRESS' ,'localhost');
}
if (defined('USER_NAME')) {} else {
	define ('USER_NAME' ,'root');
}
if (defined('PASSWORD')) {} else {
	define ('PASSWORD' ,'');
}
if (defined('DATABASE')) {} else {
	define ('DATABASE' ,'online_judge');
}
?>
