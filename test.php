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
 //   The latest error
 // Warning: mkdir(): No such file or directory in C:\xampp\htdocs\OnlineJudge\Model\Models.php on line 590
///unable to create new entry  
	<!DOCTYPE html>
<?php 
    Auth::joinSession();
    ?>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
    <![endif]-->
    <title>Online Judge</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="<?php echo $dir; ?>assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME ICONS  -->
    <link href="<?php echo $dir; ?>assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="<?php echo $dir; ?>assets/css/style.css" rel="stylesheet" />
    <style type="text/css">
    .alert-warning {
    color: #353535;
}
    </style>
</head>
<body onload="checkstatus()">
    <header>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                </div>
            </div>
        </div>
    </header>
    <!-- HEADER END-->
    <div class="navbar navbar-inverse set-radius-zero">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">
                <img src="<?php echo $dir; ?>assets/img/logo.png" height="101" width="230"/>
                </a>
            </div>
            <div class="left-div">
                <div class="user-settings-wrapper">
                    <ul class="nav">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                            <span class="glyphicon glyphicon-user" style="font-size: 25px;"></span>
                            </a>
                            <div class="dropdown-menu dropdown-settings">
                                <div class="media">
                                    <a class="media-left" href="#">
                                    <img src="<?php echo $dir; ?>assets/img/64-64.jpg" alt="" class="img-rounded" />
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading">Jhon Deo Alex </h4>
                                        <h5>Developer & Designer</h5>
                                    </div>
                                </div>
                                <hr />
                                <h5><strong>Personal Bio : </strong></h5>
                                Anim pariatur cliche reprehen derit.
                                <hr />
                                <a href="#" class="btn btn-info btn-sm">Full Profile</a>&nbsp; <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- LOGO HEADER END-->
    <section class="menu-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <li><a class="menu-top-active " href="index.php">Home</a></li>
                            <li><a >||</a></li>
                            <li><a href="questionUpload.php">Submit Ques.</a></li>
                            <li><a href="viewQuestion.php">View Question</a></li>
                            <li><a href="login.php">Login Page</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">View Question</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <div class="alert alert-warning">
                        <p><strong>PROBLEM TAG: </strong></p>
                        <p><strong>PROBLEM :</strong> <span style="position: absolute;left: 300px;"  ><?php echo $question->questionTitle; ?></span></p>
                        <p><strong>EXPLANATION:</strong></p><pre></pre>
                        <p><strong>DIFFICULTY:</strong> <span style="position: absolute;left: 300px;"  ><?php echo $question->difficulty; ?></span></p>
                        <strong>START TIME :</strong><span style="position: absolute;left: 300px;"  ><?php echo $question->startTime; ?></span><br>
                        <!-- <input type="time" value="12:01:00;"> -->
                        <strong>END TIME :</strong><span style="position: absolute;left: 300px;"  ><?php echo $question->endTime; ?></span>
                        <!-- <input type="time" value="12:01:00;"> -->
                        <h5 style=" border-bottom: 1px dashed;"></h5>
                        <p>Author: <b><?php echo $user->name; ?></b></p>
                        <p>Tester: </p>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="alert alert-warning">
                        <div class="panel-body">
                  <div class="table-responsive">
                     <table class="table table-striped table-hover">
                        <tbody>
                           <tr>
                              <th>User</th>
                              <th>Score</th>
                              <th>Memory</th>
                              <th>Lang</th>
                              <th>Solution</th>
                           </tr>
                           <?php foreach ($arr as $var) {
                              echo "<tr>";
                              echo "<td>$var->name</td>";
                              echo "<td>$var->marks</td>";
                              echo "<td>$var->memory</td>";
                              echo "<td>$var->language</td>";
                              echo "<td><a href=\"\"  class=\"btn btn-xs btn-danger pull-right\" >View</a> </td>";
                              echo "</tr>";
                              
                              } ?>
                        </tbody>
                        
                     </table>
                  </div>
               </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    
                        <div class ="col-md-offset-5">
                            <!--  * if student is logged in & question is live then submit answer should be there.
                                * if student is logged in & question has ended then no button should be there besides there must be ranking sidebar and view their answers.
                                * if teacher is logged in there should be start and end button.
                                -->
                            <?php 
                                if (Auth::userType() == 'Student'){
                                    if (Question::isActive($_SESSION['questionId'])){ ?>
                                        <a href="submitAnswer.php"><button id="myBtn" class="btn btn-success">Submit Answer</button></a>
                            <?php }else{ ?> 
                            <?php } 
                                }else{
                                    if (Question::isActive($_SESSION['questionId'])){ ?>
                                        <button onclick="hasStarted();"  type="submit" id="myBtn"  class="btn btn-success" style="min-height: 50px;min-width: 100px;border-radius: 40px;" >
                                        <b><p id="check">start</p></b>
                                        </button>
                              <?php }else{?>
                                        <form method="POST" action="startQuestion.php">
                                            <button name="start" value="start" type="submit" id="myBtn"  class="btn btn-success" style="min-height: 50px;min-width: 100px;border-radius: 40px;" >
                                            <b><p id="check">start</p></b>
                                            </button>
                                        </form>
                                    }
                               } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    &copy; Under: Samrat Mondal | By : Aditya Gupta, Rahul Arya, Sunny Narayan
                </div>
            </div>
        </div>
    </footer>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY SCRIPTS -->
    <script src="<?php echo $dir; ?>assets/js/jquery-1.11.1.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="<?php echo $dir; ?>assets/js/bootstrap.js"></script>
    <script type="text/javascript">
        function hasStarted(){
            alert("The Question has already started.");
        } 
    </script>
</body>
</html>
 ?>