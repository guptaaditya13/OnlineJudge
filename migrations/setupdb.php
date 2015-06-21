<?php 
/**
 * This file is used for creating tables in database and setting up data for the starter.
 */

require('../connection.php');
$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);

$sql = "CREATE TABLE IF NOT EXISTS `user_table` (`id` int(11) NOT NULL,`username` varchar(40) NOT NULL,`password` char(40) DEFAULT NULL,`token` char(40) DEFAULT NULL,`cookie` char(40) DEFAULT NULL,`last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,`email` varchar(100) NOT NULL,`name` varchar(100) NOT NULL,`total_logins` int(11) NOT NULL DEFAULT '0')";
mysqli_query($conn,$sql);
$sql = "ALTER TABLE `user_table` ADD PRIMARY KEY (`id`) COMMENT 'User id for the database';";
mysqli_query($conn,$sql);
$sql = "ALTER TABLE `user_table` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
mysqli_query($conn,$sql);
$sql = "ALTER TABLE `user_table` ADD `type` INT(1)0 NOT NULL DEFAULT '0' COMMENT 'stores the type of user' ;";
mysqli_query($conn,$sql);
mysqli_close($conn);
?>