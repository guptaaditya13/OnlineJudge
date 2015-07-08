<!DOCTYPE html> <!-- add action to submit -->
<head>
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
   <meta name="description" content="" />
   <meta name="author" content="" />
   <title>Online Judge</title>
   <!-- BOOTSTRAP CORE STYLE  -->
   <link href="<?php echo $dir; ?>assets/css/bootstrap.css" rel="stylesheet" />
   <!-- FONT AWESOME ICONS  -->
   <link href="<?php echo $dir; ?>assets/css/font-awesome.css" rel="stylesheet" />
   <!-- CUSTOM STYLE  -->
   <link href="<?php echo $dir; ?>assets/css/style.css" rel="stylesheet" />
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
         <div class="left-div">
            <i class="fa fa-user-plus login-icon" ></i>
         </div>
      </div>
   </div>
   <!-- LOGO HEADER END-->
   <!-- MENU SECTION END-->
   <div class="content-wrapper">
      <div class="container">
         <div class="row">
            <div class="col-md-12">
               <h4 class="page-head-line">Please Login To Enter </h4>
            </div>
         </div>
         <div class="row">
            <form name="form1" action="login.php" method="POST">
               <div class="col-md-6 col-md-offset-3 alert alert-success">
                  <h4>  Login with <strong>Private Account  :</strong></h4>
                  <br />
                  <label>Enter Username : </label>
                  <input type="text" name="username" class="form-control" placeholder="example: rahul.cs13 / samrat" />
                  <label>Enter Password :  </label>
                  <input type="password" name="password" class="form-control" placeholder="*********"/>
                  <br>
                  <?php Auth::embedCSRF(); ?>
                  <button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-user"></span>  Log Me In</button>
               </div>
            </form>
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
</body>
</html>