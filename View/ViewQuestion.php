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
     <!-- HTML5 Shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <header>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
      <!--               <strong>Email: </strong>info@yourdomain.com
                    &nbsp;&nbsp;
                    <strong>Support: </strong>+90-897-678-44
       -->          </div>

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
                <div class="col-md-12">
                    <div class="alert alert-warning">
                        <p><strong>PROBLEM TAG: </strong></p>
                        <p>Author: <b><?php echo $user->name; ?></b></p>
                        <p>Tester: </p>
                        <p><strong>DIFFICULTY: <?php echo $question->difficulty; ?></strong></p>



                        <p><strong>START TIME :</strong></p>
                        <!-- <input type="time" value="12:01:00;"> -->
                        <input name="StartTime" value = "<?php echo $question->startTime; ?>" class="inputs time" disabled>
                        <p><strong>END TIME :</strong></p>
                        <!-- <input type="time" value="12:01:00;"> -->
                        <input name="EndTime" value = "<?php echo $question->endTime; ?>" class="inputs time" disabled>
                        
                        <p><strong>PROBLEM :</strong> <?php echo $question->questionText; ?></p>

                        <p><strong>SHORT EXPLANATION</strong></p>

                        <p><strong>EXPLANATION:</strong></p>
                        <div class ="col-md-offset-5"><button type="submit" id="myBtn"  class="btn btn-success" ><p id="check">start</p></button></div>

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
</body>
</html>
