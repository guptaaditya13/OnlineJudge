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
   <script type="text/javascript">
var countIn = 1;
var countOut = 1;
function addInput(divName){
   var newdiv = document.createElement('div');
   newdiv.innerHTML = "Input " + (countIn + 1) + " <br><textarea name='myInputs[]'></textarea>";
   document.getElementById(divName).appendChild(newdiv);
   countIn++;
    
}
function addOutput(divName){
   var newdiv = document.createElement('div');
   newdiv.innerHTML = "Output " + (countOut + 1) + " <br><textarea name='myOutputs[]'></textarea>";
   document.getElementById(divName).appendChild(newdiv);
   countOut++;
}  
</script>
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
         <div class="alert alert-warning">
            <select id= "sampleOrTest" onclick="changeAction()">
               <option selected value="uploadSample.php?qno=<?php echo $_GET['qno']; ?>">Sample input</option>
               <option value="uploadTestCase.php?qno=<?php echo $_GET['qno']; ?>">Test Cases</option>
            </select>
          <form action="uploadSample.php?qno=<?php echo $_GET['qno']; ?>" method="POST" id="myform">            <!-- add action for submitSample.php   -->
            <label>Question Name:</label>
            <div id="dynamicInput">
               Input 1<br><textarea name="myInputs[]"></textarea>
            </div>
            <span style="position: absolute;left: 400px;top:283px;"  ><div id="dynamicOutput">
               Output 1<br><textarea name="myOutputs[]"></textarea>
            </div></span>
            <div>
            <input type="button" value="Add another text input" onClick="addInput('dynamicInput');addOutput('dynamicOutput');">
            <input type="submit" name= "submit" value="submit"></div>
         </form>
           
         <!--  end  Context Classes  -->
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
   <!-- BOOTSTRAP SCRIPTS  -->
   <script src="<?php echo $dir ?>assets/js/bootstrap.js"></script>
   <script type="text/javascript">
   function changeAction () {
      var val = document.getElementById("sampleOrTest").value;
      document.getElementById("myform").action= val;


      // body...
   }</script>
</body>
</html>
