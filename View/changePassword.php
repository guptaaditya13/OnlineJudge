<!DOCTYPE html> <!-- add action to submit -->
<head>
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
   <meta name="description" content="" />
   <meta name="author" content="" />
   <title>Online Judge</title>
   <link href="<?php echo $dir; ?>assets/css/bootstrap.css" rel="stylesheet" />
   <link href="<?php echo $dir; ?>assets/css/font-awesome.css" rel="stylesheet" />
   <link href="<?php echo $dir; ?>assets/css/style.css" rel="stylesheet" />
</head>
<body>
   <header>
      <div class="container">
         <div class="row">
         </div>
      </div>
   </header>
   <div class="navbar navbar-inverse set-radius-zero">
      <div class="container">
         <div class="navbar-header">
            <a class="navbar-brand" href="index.php">
            <img src="<?php echo $dir; ?>assets/img/logo.png" />
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
               <h4 class="page-head-line">Change Password </h4>
            </div>
         </div>
         <div class="row">
            <form name="form2" action="" method="POST">
               <div class="col-md-6 col-md-offset-3 alert alert-success">
                  <h4>  Enter details of your <strong>Private Account  :</strong></h4>
                  <br />
                  <label>Enter Old Password :  </label>
                  <input type="password" name="oldPassword" class="form-control" onsubmit="passwd_validate()" placeholder="*********"/>
                  <br>
                  <label>Enter New Password :  </label>
                  <input id="user_password" type="password" name="newPassword" class="form-control" onkeyup="chkPasswordStrength();allowAccess()" placeholder="*********"/>
                  <b id="strength">
                  </b>
                  <br>
                  <label>Confirm New Password :  </label>
                  <input id="repeat" type="password" name="confirmPassword" class="form-control" onkeyup="allowAccess()" placeholder="*********"/>
                  <b id="allow">
                  </b>
                  <br>
                  <button type="submit" id="submitted" name="CHANGE"class="btn btn-info"><span class="glyphicon glyphicon-user"></span>  Change</button>
               </div>
            </form>
         </div>
      </div>
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
   <script src="<?php echo $dir; ?>assets/js/jquery-1.11.1.js"></script>
   <!-- BOOTSTRAP SCRIPTS  -->
   <script src="<?php echo $dir; ?>assets/js/bootstrap.js"></script>
   <script type="text/javaScript">
      function passwd_validate()
      {
          if((document.form2.newPasswd1.length<8) || (document.form2.newPasswd1.length>20))
          {
              document.getElementById('passwd').innerHTML="The password length is not appropriate";
              form2.newPasswd1.focus();
              return(false);
          }
      }
       var count1=0;
       var count2=0;
        function chkPasswordStrength()
        {
      
          document.getElementById("submitted").disabled = true;
          var desc = new Array();
           desc[0] = "Very Weak";
           desc[1] = "Weak";
           desc[2] = "Better";
           desc[3] = "Medium";
           desc[4] = "Strong";
           desc[5] = "Strongest";
          var password_check= document.getElementById("user_password").value;
          var size=password_check.length;
          var str="";
          if(size<8)
          {
              str=",Too Short";
          }
          else if(size>=8 && size<=20)
          {
              str=",Length okay"
          }
          else
              str=",Too Long";
      
          var len=0;
          if(password_check.match(/[a-z]/))
          {
              count1=0;
              len++;
          }
          if(password_check.match(/[A-Z]/))
          {
              count1=0;
              len++;
          }
          if(password_check.match(/\d+/))
          {
              count1=0;
              len++;
          }
          if ( password_check.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) ) 
          {
              count1=0;
              len++;
          }
          if(password_check.length>12)
          {
              count1=0;
              len++;
          }
          document.getElementById("strength").innerHTML = desc[len]+ str; 
          if((desc[len].localeCompare(desc[4])==0) || (desc[len].localeCompare(desc[5]))==0)
          {
              count1=1;
              document.getElementById("submitted").disabled = true;
          }
          
        } 
        function setValue(objec,value){
          document.getElementById(objec).innerHTML= value;
        }
        function allowAccess() 
        {
      
          var neww=document.getElementById("repeat").value;
          var old=document.getElementById("user_password").value;
          if (neww.localeCompare("") == 0)
          {
              setValue("allow","");
              count2=0;
              document.getElementById("submitted").disabled = true;
          }
          else if(neww.localeCompare(old)==0)
          {
              setValue("allow","Matched");
              count2=1;
              document.getElementById("submitted").disabled = true;
          } 
          else
          {
              setValue("allow","Not Matched");
              count2=0;
              document.getElementById("submitted").disabled = true;
          }
          if(count1==1 && count2==1 && neww.length>=8 && neww.length<=20)
           {
              // setValue("go","Allowed");
              document.getElementById("submitted").disabled = false;
           }
        }
   </script>
   <script>
      $(document).ready(function() {
      
          $('#dataTables-example').DataTable({
                  responsive: true
          });
      });
   </script>
</body>
</html>