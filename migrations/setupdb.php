<?php 
/**
 * This file is used for creating tables in database and setting up data for the starter.
 */

require('../connection.php');
$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);

/**
 * Generating user_table
 */
$sql = "CREATE TABLE IF NOT EXISTS `user_table` (`id` int(11) NOT NULL,`username` varchar(40) NOT NULL,`password` char(40) DEFAULT NULL,`token` char(40) DEFAULT NULL,`cookie` char(40) DEFAULT NULL,`last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,`email` varchar(100) NOT NULL,`name` varchar(100) NOT NULL,`total_logins` int(11) NOT NULL DEFAULT '0')";
mysqli_query($conn,$sql);
$sql = "ALTER TABLE `user_table` ADD PRIMARY KEY (`id`) COMMENT 'User id for the database';";
mysqli_query($conn,$sql);
$sql = "ALTER TABLE `user_table` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
mysqli_query($conn,$sql);
$sql = "ALTER TABLE `user_table` ADD `type` INT(1) NOT NULL DEFAULT '0' COMMENT 'stores the type of user' ;";
mysqli_query($conn,$sql);

/**
 * Generating question_table
 */
$sql = "CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `q_text` text DEFAULT NULL,
  `q_image` varchar(20) DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `max_marks` int(11) NOT NULL,
  `difficulty` int(1) NOT NULL,
  `sample_inp` text NOT NULL,
  `sample_out` text NOT NULL,
  `timestamps` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
mysqli_query($conn,$sql);
$sql = "ALTER TABLE `questions` ADD PRIMARY KEY (`id`) COMMENT 'User id for the database';";
mysqli_query($conn,$sql);
$sql = "ALTER TABLE `user_table` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
mysqli_query($conn,$sql);
$sql = "ALTER TABLE `questions` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;";
mysqli_query($conn,$sql);
$sql = "ALTER TABLE `questions` CHANGE `q_image` `q_image` VARCHAR(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL, CHANGE `sample_inp` `sample_inp` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, CHANGE `sample_out` `sample_out` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;";
mysqli_query($conn,$sql);
mysqli_close($conn);
?>