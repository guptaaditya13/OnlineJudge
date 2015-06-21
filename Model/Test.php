<?php 
require('../connection.php');
$sql = "INSERT INTO `online_judge`.`questions` (`id`, `user_id`, `q_text`, `q_image`, `start_time`, `end_time`, `max_marks`, `sample_inp`, `sample_out`, `timestamps`) VALUES (NULL, '1', 'kjb', 'kjb', '2015-06-11 00:00:00', '2015-06-26 00:00:00', '10', 'kh', 'kjb', CURRENT_TIMESTAMP);";
$conn = mysqli_connect(SERVER_ADDRESS,USER_NAME,PASSWORD,DATABASE);
$result = mysqli_query($conn,$sql);
var_dump($result);
 ?>