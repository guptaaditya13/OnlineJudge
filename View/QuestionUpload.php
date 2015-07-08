<!DOCTYPE html>
<!-- <html xmlns="http://www.w3.org/1999/xhtml"> -->
<head>
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
   <meta name="description" content="" />
   <meta name="author" content="" />
   <!--[if IE]>
   <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
   <![endif]-->
   <title>Online Judge</title>
   <!-- BOOTSTRAP CORE STYLE  -->
   <link href="<?php echo $dir; ?>assets/css/bootstrap.css" rel="stylesheet" />
   <!-- FONT AWESOME ICONS  -->
   <link href="<?php echo $dir; ?>assets/css/font-awesome.css" rel="stylesheet" />
   <!-- CUSTOM STYLE  -->
   <link href="<?php echo $dir; ?>assets/css/style.css" rel="stylesheet" />
   
   <script type="text/javascript">
      function TimeValidate()
      {   
      
          var start = document.getElementById("start_time").value;
          var end = document.getElementById("end_time").value;
          
          
                  if(start > end)
          {
                  document.getElementById("start").style.color = 'red';
                  document.getElementById("start").innerHTML="Start time can't exceed End time ";
                  document.getElementById("myBtn").disabled = true;
          }
          else if(start < end)
          {
              document.getElementById("start").style.color = 'green';
              document.getElementById("start").innerHTML="Ok ";
              document.getElementById("end").style.color = 'green';
              document.getElementById("end").innerHTML="Ok ";
      
              document.getElementById("myBtn").disabled = false;
      
          }
          
      }
      function DateValidate()
      {
          var start = document.getElementById("start_date").value;
          var end = document.getElementById("end_date").value;
      
          document.getElementById("myBtn").disabled = true;
          if(start > end)
          {
                  document.getElementById("start").style.color = 'red';
                  document.getElementById("start").innerHTML="Start Date can't exceed End date ";
          }
          else if(start <= end)
          {
              document.getElementById("start").style.color = 'green';
              document.getElementById("start").innerHTML="Ok ";
              document.getElementById("end").style.color = 'green';
              document.getElementById("end").innerHTML="Ok ";
      
              document.getElementById("myBtn").disabled = false;
          }
          
      }
      
   </script>
   <style type="text/css" media="all">
      @import "<?php echo $dir; ?>assets/css/widgEditor.css";
   </style>
</head>
<body>
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
                           <img src="<?php echo $dir; ?>assets/img/<?php echo $_SESSION['auth_username']; ?>.jpg" alt="" class="img-rounded" />
                           </a>
                           <div class="media-body">
                              <h4 class="media-heading"> <?php echo $_SESSION['auth_username']; ?></h4>
                              <h5><?php echo $_SESSION['auth_username']; ?></h5>
                           </div>
                        </div>
                        <hr />
                        <h5><strong>Personal Bio : </strong></h5>
                        <?php echo $_SESSION['auth_username']; ?>
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
               <h4 class="page-head-line">Upload Question</h4>
            </div>
         </div>
         <form action="questionUpload.php" method="POST" enctype="multipart/form-data">
            <div class="row">
               <div class="col-md-12">
                  <div class="alert alert-warning">
                     <p>Author: </p>
                     <input class="form-control" name="author"  required value="<?php echo $_SESSION['auth_name']; ?>">
                     <p>Tester: </p>
                     <input class="form-control" name="tester"  >
                     <p><strong>DIFFICULTY:</strong></p>
                     <select name="difficulty" class="form-control">
                        <option  value="easy" >Easy</option>
                        <option  value="medium">Medium</option>
                        <option  value="hard">Hard</option>
                        <option  value="challenge">Challenge</option>
                     </select>
                     <label>Start Date Time&nbsp;&nbsp;(MM-DD-YYYY hh:mm AM/PM)</label>
                     <input type="datetime-local" class="form-control" required value="" id="start_date" name="start_date" placeholder="Select Start date">
                     <p id="start"></p>
                     <label>End Date Time&nbsp;&nbsp;(MM-DD-YYYY hh:mm AM/PM)</label>
                     <input type="datetime-local" class="form-control" id="end_date" onchange='DateValidate()' required value="" name="end_date" placeholder="Select End date">
                     <p id="end"></p>
                     <div class="row">
                        <p><strong>Title</strong></p>
                        <input type ="text "class="form-control" name="title" />
                        <div  class="col-md-10">
                           <p><strong>PROBLEM:</strong></p>
                           <textarea class="form-control" name="question" rows="1"  ></textarea>
                        </div>
                        <div class="col-md-2">
                           <p><strong> Max marks<strong/> </p>
                           <input type="number" class="form-control" name="maxMarks" value="100" required/>
                        </div>
                     </div>
                     <p><strong>EXPLANATION:</strong></p>
                     <textarea id="noise" name="FullExplain" class="widgEditor nothing"></textarea>
                     <input type="file" name="fileToUpload" id="fileToUpload" multiple >
                      <div class ="col-md-offset-5"><button type="submit" id="myBtn" onclick='TimeValidate()' class="btn btn-success" disabled>Submit</button></div>
                  </div>
               </div>
            </div>
            <!-- <button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-user"></span> Submit </button> -->
         </form>
      </div>
   </div>
   <!-- CONTENT-WRAPPER SECTION END-->
   <footer>
      <div class="container">
         <div class="row">
            <div class="col-md-12">
               &copy; Under: Samrat Mondal | By : Aditya Gupta, Rahul Arya, Sunny Narayan</a>
            </div>
         </div>
      </div>
   </footer>
   <!-- FOOTER SECTION END-->
   <!-- JAVASCRIPT AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
   <!-- CORE JQUERY SCRIPTS -->
   <script type="text/javascript" src="<?php echo $dir; ?>assets/js/widgEditor.js"></script>
   <script src="<?php echo $dir; ?>assets/js/jquery-1.11.1.js"></script>
   <script type="text/javascript">
    var countImg = 1;
    function addInput(divName){
       var newdiv = document.createElement('div');
       newdiv.innerHTML = "Input " + (countImg + 1) + " <br><input type='file' accept='image/*' name='myImages[]' />";
       document.getElementById(divName).appendChild(newdiv);
       countImg++;
        
    }
   </script>
   <!-- BOOTSTRAP SCRIPTS  -->
   <script src="<?php echo $dir; ?>assets/js/bootstrap.js"></script>
</body>
</html>