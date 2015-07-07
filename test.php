<?php 
	$timezone = date_default_timezone_get();
echo "The current server timezone is: " . $timezone;
	echo "Today is " . date("Y/m/d") . "<br>";
	echo "The time is " . date("h:i:sa") . "<br>"   ;


// 	$sql = "SELECT NOW()";
// 	$conn = mysqli_connect("localhost","root","sunny424","online_judge");
// 	$result = mysqli_query($conn,$sql);
// 	echo $result;
	// // <!-- * if student is logged in & question is live then submit answer should be there.
 //     * if student is logged in & question has ended then no button should be there besides there must be ranking sidebar and view their answers.
 //     * if teacher is logged in there should be start and end button.
 // -->
 //                         <!--<?php
 //                        // if (Auth::userType() == 'Student'){
 //                        //     if (strtotime($var->endTime) > time() && ){ >?
 //                        //         <a href="#"><button id="myBtn"  class="btn btn-success" >Submit Answer</button></a>
 //                        //     <?php 
 //                        //     }else{

 //                        //     }
 //  
 ?>