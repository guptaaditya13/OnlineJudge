<!DOCTYPE html>
<!-- <html xmlns="http://www.w3.org/1999/xhtml"> -->
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
   <script src="<?php echo $dir ?>assets/js/jquery-1.11.1.js"></script>
</head>
<body>
   <header>
      <div class="container">
         <div class="row">
         </div>
      </div>
   </header>
   <!-- HEADER END-->
   <div class="navbar navbar-inverse set-radius-zero">
      <div class="container">
         <div class="navbar-header">
            <a class="navbar-brand" href="index.php">
            <img src="<?php echo $dir; ?>assets/img/logo.png" height="101" width="230" />
            </a>
         </div>
         <?php if (Auth::loginStatus()){  ?>
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
                           <img src="<?php echo $dir; ?>assets/img/<?php echo $_SESSION['auth_username']; ?>.jpg" alt="" class="img-rounded" />
                           </a>
                           <div class="media-body">
                              <h4 class="media-heading"> <?php echo $_SESSION['auth_name']; ?></h4>
                              <h5>......</h5>
                           </div>
                        </div>
                        <!-- <hr />
                           <?php echo $_SESSION['auth_name']; ?>
                           <hr /> --><br>
                        <a href="#" class="btn btn-info btn-sm" style="width:150px;">Full Profile</a><br>
                        <a href="#" class="btn btn-info btn-sm" style="width:150px;">Change password</a><br>
                        <a href="logout.php" class="btn btn-danger btn-sm" style="width:150px;">Logout</a>
                     </div>
                  </li>
               </ul>
            </div>
         </div>
         <?php } ?>
      </div>
   </div>
   <!-- LOGO HEADER END-->
   <section class="menu-section">
      <div class="container">
         <div class="row">
            <div class="col-md-12">
               <div class="navbar-collapse collapse ">
                  <ul id="menu-top" class="nav navbar-nav navbar-right">
                     <li><a class="menu-top-active " href="<?php echo ROUTE_CONTROLLER; ?>index.php">Home</a></li>
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
               <h1 class="page-head-line">Welcome</h1>
            </div>
         </div>
         <div class="col-md-5">
            <div class="notice-board">
               <div class="panel panel-default">
                  <div class="panel-heading">
                     Active  Notice Panel 
                     <div class="pull-right" >
                        <div class="dropdown">
                           <button class="btn btn-success dropdown-toggle btn-xs" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                           <span class="glyphicon glyphicon-cog"></span>
                           <span class="caret"></span></button>
                           <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                              <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Refresh</a></li>
                           </ul>
                        </div>
                     </div>
                  </div>
                  <div class="panel-body">
                  </div>
                  <div class="panel-footer">
                     <a href="#" class="btn btn-default btn-block"> <i class="glyphicon glyphicon-repeat"></i> Just A Small Footer Button</a>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-7">
            <!--   Kitchen Sink -->
            <div class="panel panel-default">
               <div class="panel-heading">
                  Recent Question
               </div>
               <div class="panel-body">
                  <div class="table-responsive">
                     <table class="table table-striped table-hover">
                        <tbody>
                           <tr>
                              <th>Question</th>
                              <th>Start time</th>
                              <th>End time</th>
                           </tr>
                           <?php foreach ($arr as $var) {
                              /**
 * If condition for checking if the question is live or not
 */

                                    if (Question::isActive($var->questionId)){
                                            echo "<tr>";
                                            echo "<td>$var->questionTitle</td>";
                                            echo "<td>$var->startTime</td>";
                                            echo "<td>$var->endTime</td>";
                                            echo "<td><a href=\"viewQuestion.php?questionId=$var->questionId\"  class=\"btn btn-xs btn-success pull-right\" >View</a> </td>";
                                            echo "</tr>";
                                    }else{
                                            echo "<tr>";
                                            echo "<td>$var->questionTitle</td>";
                                            echo "<td>$var->startTime</td>";
                                            echo "<td>$var->endTime</td>";
                                            echo "<td><a href=\"viewQuestion.php?questionId=$var->questionId\"  class=\"btn btn-xs btn-danger pull-right\" >View</a> </td>";
                                            echo "</tr>";
                                    }

                              
                              } ?>
                        </tbody>
                        <a href="#"  class="btn btn-xs btn-success pull-right"  >View All</a>
                     </table>
                  </div>
               </div>
            </div>
            <!-- End  Kitchen Sink -->
         </div>
         <!--  end  Context Classes  -->
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
   <!-- BOOTSTRAP SCRIPTS  -->
   <script src="<?php echo $dir ?>assets/js/bootstrap.js"></script>
</body>
</html>
