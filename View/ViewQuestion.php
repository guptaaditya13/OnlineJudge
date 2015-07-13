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
                        <p><strong>PROBLEM TITLE: </strong><span style="position: absolute;left: 300px;"  ><?php echo $question->questionTitle; ?></span></p>
                        <p><strong>PROBLEM :</strong> <span style="position: absolute;left: 300px;"  ><pre><?php echo htmlspecialchars_decode($question->questionText); ?></pre></span></p>
                        <p><strong>DIFFICULTY:</strong> <span style="position: absolute;left: 300px;"  ><?php echo $question->difficulty; ?></span></p>
                        <strong>START TIME :</strong><span style="position: absolute;left: 300px;"  ><?php echo $question->startTime; ?></span><br>
                        <!-- <input type="time" value="12:01:00;"> -->
                        <strong>END TIME :</strong><span style="position: absolute;left: 300px;"  ><?php echo $question->endTime; ?></span>
                        <!-- <input type="time" value="12:01:00;"> -->
                        <h5 style=" border-bottom: 1px dashed;"></h5>
                        <p>Author: <b><?php echo $user->name; ?></b></p>
                        <p>Tester: <b><?php echo $question->tester; ?></b></p>
                        <p>Sample Input &amp; Output: </p>
                        <ol>
                        <?php 
                        for ($i=0; $i < $sample; $i++) { 
                            ?>
                        <li><p><strong>INPUT :</strong> <a href="downloadSampleInput.php?qno=<?php echo $_GET['questionId']; ?>&amp;sample=<?php echo $i+1; ?>">download</a><span style="position: absolute;left: 300px;"  ><pre><?php echo $inp[$i]; ?></pre></span></p>
                        <p><strong>OUTPUT :</strong> <a href="downloadSampleOutput.php?qno=<?php echo $_GET['questionId']; ?>&amp;sample=<?php echo $i+1; ?>">download</a><span style="position: absolute;left: 300px;"  ><pre><?php echo $out[$i]; ?></pre></span></p></li>
                        <?php }
                         ?>
                        </ol>
                        <?php 
                        if ($hasAccess){
                        ?>
                        <p>Test Cases: </p>
                        <ol>
                        <?php
                        for ($i=0; $i < $tc; $i++) { 
                            ?>
                        <li><p><strong>INPUT :</strong> <a href="downloadTestCaseInput.php?qno=<?php echo $_GET['questionId']; ?>&amp;tc=<?php echo $i+1; ?>">download</a><span style="position: absolute;left: 300px;"  ><pre><?php echo $tinp[$i]; ?></pre></span></p>
                        <p><strong>OUTPUT :</strong> <a href="downloadTestCaseOutput.php?qno=<?php echo $_GET['questionId']; ?>&amp;tc=<?php echo $i+1; ?>">download</a><span style="position: absolute;left: 300px;"  ><pre><?php echo $tout[$i]; ?></pre></span></p></li>
                        <?php
                        } 
                        ?>
                        </ol>
                        <?php } ?>
                        
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="alert alert-warning">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <tbody>
                                    <tr>
                                        <th>Title</th>
                                        <th>Score</th>
                                        <th>Memory</th>
                                        <th>Lang</th>
                                        <th>Solution</th>
                                    </tr>
                                    <?php foreach ($arr as $var) {
                                        echo "<tr>";
                                        echo "<td>$var->title</td>";
                                        echo "<td>$var->marks</td>";
                                        echo "<td>$var->memory</td>";
                                        echo "<td>$var->language</td>";
                                        echo "<td><a href=\"\"  class=\"btn btn-xs btn-danger pull-right\" >Comp. & Exec.</a> </td>";
                                        echo "</tr>";
                              
                                        } ?>
                                    </tbody>
                        
                                </table> 
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

                                    if (Question::isActive($_GET['questionId'])){ ?>
                            <a href=<?php echo "submitAnswer.php?questionId=".$_SESSION['questionId'];?>><button id="myBtn" class="btn btn-success">Submit Answer</button></a>
                            <?php }else{ ?> 
                            <?php } 
                                }else{?>
                                <form method="POST" action="startQuestion.php"></form>
                            <button  type="submit" id="myBtn"  class="btn btn-success" style="min-height: 50px;min-width: 100px;border-radius: 40px;" >
                                <b><p id="check">start</p></b>
                            </button>
                             <a href = "uploadSample.php?qno=<?php echo $_GET['questionId']; ?>"> <button id="myBtn"   class="btn btn-success" style="min-height: 50px;min-width: 100px;border-radius: 40px;" >
                                <b><p id="check">Upload testcase </p></b>
                            </button></a>
                            <?php } ?>
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
        function checkstatus () {
            
        
        }
    </script>
</body>
</html>