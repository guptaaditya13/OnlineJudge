<html>
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
                           <a href="changePassword.php" class="btn btn-info btn-sm" style="width:150px;">Change password</a><br>
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
      <!-- CONTENT-WRAPPER SECTION END-->
      <div class="content-wrapper">
         <div class="container">
            <div class="row">
               <div class="col-lg-12">
                  <h4 class="page-head-line">Basic Information</h4>
               </div>
               <div class="panel-body">
                  <div class="row">
                     <div class="col-lg-6">
                        <h2>Personal Detail</h2>
                        <form name="" method="POST" action="">
                        <!--see for action-->
                        <fieldset disabled="">
                           <div class="form-group">
                              <label for="disabledSelect">Username</label>
                              <input  id="disabledInput" class="form-control" type="text" value="" >
                           </div>
                           <div class="form-group">
                              <label for="disabledSelect">Name</label>
                              <input  id="disabledInput" class="form-control" type="text" value="">
                           </div>
                           <div class="form-group">
                              <label for="disabledSelect">Email</label>
                              <input  id="disabledInput" class="form-control" type="text" value="">
                           </div>
                        </fieldset>
                     </div>
                     <!-- /.col-lg-6 (nested) -->
                     <div class="col-lg-6">
                        <h2>Contact Detail</h2>
                        <div class="form-group">
                           <label>Mobile : </label>
                           <input class="form-control" type="tel" name="mnum" required value="">
                        </div>
                        <div class="form-group">
                           <label>Office Phone : </label>
                           <input class="form-control" type="tel" name="off_ph" required value="">
                        </div>
                     </div>
                     <!-- /.col-lg-6 (nested) -->
                  </div>
                  <!-- /.row (nested) -->
               </div>
               <!-- /.panel-body -->
            </div>
            <div class="col-lg-6">
               <button type="submit" name="submit" value="Submit"   class="btn btn-success" style="float: right">Submit</button>
               <button type="reset" value="Cancel" class="btn btn-danger" style="float: right">Reset</button>
            </div>
            <!-- /.panel -->
         </div>
      </div>
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