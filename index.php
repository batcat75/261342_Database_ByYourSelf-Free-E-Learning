<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ByYourSelf : Free e-learning</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="vendor/bootstrap/css/stylish-portfolio.css" rel="stylesheet">

	<!-- Timeline CSS -->
    <link href="css/plugins/timeline.css" rel="stylesheet">
	
    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<script type="text/javascript" src="vendor/jquery/jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="dist/js/bootstrapValidator.js"></script>

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">ByYourSelf</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="register.php" >Sing up</a>
                    </li>
                    <li>
                        <a href="main_login.php" >Login</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
			
        </div>
        <!-- /.container -->
    </nav>

    <!-- Header -->
    <header id="top" class="header">
        <div class="text-vertical-center">
            <h1>ByYourSelf</h1>
            <h3>Learning Every Things, For Free!</h3>
			<?php if(isset($_GET['reg'])){ echo "<div class=\"col-md-2 col-md-offset-5 text-center\"><h3 style=\"color: Red; background-color: White; \">Register success</h3></div>"; } ?>
			<div id="loginbox" style="margin-top:50px;" class="mainbox col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2">                    
				<div class="panel panel-info" >
                    <div class="panel-heading">
                        <div class="panel-title">Login</div>
                    </div>     

                    <div style="padding-top:30px" class="panel-body" >

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            
                        <form class="form-horizontal" role="form" method="post" action="checklogin.php">
                                    
                            <div style="margin-bottom: 25px" class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								<input id="myusername" type="text" class="form-control" name="myusername" placeholder="username ">                                        
							</div>
                                
                            <div style="margin-bottom: 25px" class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
								<input id="mypassword" type="password" class="form-control" name="mypassword" placeholder="password">
							</div>

							<div style="margin-top:10px" class="form-group">
								<!-- Button -->

								<div class="col-sm-12 controls">
								  <button type="submit" class="btn btn-success ">
							login</button>
							 <button type="reset" class="btn btn-default ">
							Reset</button>
								</div>
							</div>


							<div class="form-group">
								<div class="col-md-12 control">
									<div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
										Don't have an account! 
									<a href="#" onClick="$('#loginbox').hide(); $('#signupbox').show()">
										Sign Up Here
									</a>
									</div>
								</div>
							</div>    
						</form>     

                    </div>                     
                </div>  
			</div>
			<div id="signupbox" style="display:none; margin-top:50px;" class="mainbox col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2">
				<div class="panel panel-info">
					<div class="panel-heading">
						<div class="panel-title">Sign Up</div>
						<div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="#" onclick="$('#signupbox').hide(); $('#loginbox').show()">Login</a></div>
					</div>  
					<div class="panel-body" >
						<form id="signupform" class="form-horizontal" role="form" method="post" action="check_register.php">
							  
							<div class="form-group">
								<label for="text" class="col-md-3 control-label">Username</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="myusername" placeholder="Username">
								</div>
							</div>
								
							<div class="form-group">
								<label for="password" class="col-md-3 control-label">Password</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="mypassword" placeholder="Password">
								</div>
							</div>
							<div class="form-group">
								<label for="name" class="col-md-3 control-label">Name</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="myname" placeholder="Name">
								</div>
							</div>
 
							<div class="form-group">
								<label for="email" class="col-md-3 control-label">Email</label>
								<div class="col-md-9">
									<input type="email" class="form-control" name="myemail" placeholder="Email">
								</div>
							</div>

							<div class="form-group">
								<!-- Button -->                                        
								<div class="col-md-offset-3 col-md-9">
									<button id="btn-signup" type="submit" class="btn btn-info"><i class="icon-hand-right"></i> &nbsp Sign Up</button>
								</div>
							</div>
		
						</form>
					 </div>
				</div>
			</div> 
        </div>
    </header>

    <!-- About -->
    <section id="about" class="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Knowledges are the important for every people to make they life better.</h2>
                    <p class="lead">Now, You can learn lesson,that you attention, from your gadget device for free.</p>
					<iframe width="560" height="315" src="//www.youtube.com/embed/NfN5SSiRoPs" frameborder="0" allowfullscreen></iframe>
				</div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>

    <!-- Callout -->
    <aside class="callout">
        <div class="text-vertical-center">
            <h1>Start for learning</h1>
        </div>
    </aside>
	
	<!-- TimeLine -->
    <div class="row">
		<div class="col-md-8 col-md-offset-2">
			<ul class="timeline">
				<li>
					<div class="timeline-badge"><i class="fa fa-book"></i>
					</div>
					<div class="timeline-panel">
						<div class="timeline-heading">
							<h4 class="timeline-title">Start! : Learn Some Lesson</h4>
						</div>
						<div class="timeline-body">
							<p>At the beginning, Select some Topic that you attention. Learn in our e-learning to make sure our website are make interested on you. </p>
						</div>
						<hr>
							<div class="btn-group">
								Register with us, to use full functional and can learn every topic.
							</div>
					</div>
				</li>
				<li>
					<div class="timeline-panel">
						<div class="timeline-heading">
							<h4 class="timeline-title">Learn all : Finnish all lesson in the topic</h4>
						</div>
						<div class="timeline-body">
							<p>Keep reading at end of the your topic. </p>
						</div>
					</div>
				</li>
				<li class="timeline-inverted">
					<div class="timeline-badge warning"><i class="fa fa-list-ol"></i>
					</div>
					<div class="timeline-panel">
						<div class="timeline-heading">
							<h4 class="timeline-title">Test : challenge your knowledge</h4>
						</div>
						<div class="timeline-body">
							<p>If you Finnish some topic your can make the test.</p>
							<p>Test will tall you about your knowledge of that topic and your prepare to the higher topic ready or not.</p>
						</div>
					</div>
				</li>
				<li>
					<div class="timeline-badge danger"><i class="fa fa-repeat"></i>
					</div>
					<div class="timeline-panel">
						<div class="timeline-heading">
							<h4 class="timeline-title">Learn more! : Find the new Topic.</h4>
						</div>
						<div class="timeline-body">
							<p>One topic this not enough. Learn other topic other lesson to full fill you knowledge.</p>
						</div>
					</div>
				</li>
				<li class="timeline-inverted">
					<div class="timeline-badge success"><i class="fa fa-graduation-cap"></i>
					</div>
					<div class="timeline-panel">
						<div class="timeline-heading">
							<h4 class="timeline-title">Graduated : Finnish</h4>
						</div>
						<div class="timeline-body">
							<p>Learn all topic in our website but it not game over, back to our website in someday we will have new topic for you.</p>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</div>
    <!-- /.row timelines -->
	
	<!-- Team -->
    <!-- The circle icons use Font Awesome's stacked icon classes. For more information, visit http://fontawesome.io/examples/ -->
    <section id="services" class="services bg-primary">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-10 col-lg-offset-1">
                    <h2>Our Team</h2>
                    <hr class="small">
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <div class="service-item">
                                <img src="img/new1.jpg" alt="Mountain View" style="width:180px;height:180px" class="img-circle">
                                <h4>
                                    <strong>Thitikorn Luangtongkhom</strong>
                                </h4>
                                <i class="fa fa-map-marker fa-lg"></i><p>CPE #21<br>550610500</p>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="service-item">
                               <img src="img/puu.jpg" alt="Mountain View" style="width:180px;height:180px" class="img-circle">
                                <h4>
                                    <strong>Nakarin Apirakyotin</strong>
                                </h4>
                                <i class="fa fa-map-marker fa-lg"></i><p>CPE #21<br>550610516</p>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="service-item">
                                <img src="img/nut.jpg" alt="Mountain View" style="width:180px;height:180px" class="img-circle">
                                <h4>
                                    <strong>Sasiwimol Jaisin</strong>
                                </h4>
                                 <i class="fa fa-map-marker fa-lg"></i><p>CPE #21<br>550610546</p>
							</div>
                        </div>
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.col-lg-10 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-sm-7 text-left">
                    <h4><strong>ByYourSelf</strong>
                    </h4>
                    <p>Contact Us.</p>
                    <br>
                    <ul class="list-inline">
                        <li>
                            <a href="http://www.facebook.com"><i class="fa fa-facebook fa-fw fa-3x"></i></a>
                        </li>
                        <li>
                            <a href="http://www.twitter.com"><i class="fa fa-twitter fa-fw fa-3x"></i></a>
                        </li>
                        <li>
                            <a href="http://www.dribbble.com"><i class="fa fa-dribbble fa-fw fa-3x"></i></a>
                        </li>
                    </ul>
                    <hr class="small">
                    <p class="text-muted">Copyright &copy; CPE#21 ,CMU</p>
                </div>
				<div class="col-sm-3 col-lg-offset-2 text-left">
                    <h3><strong>Simple Topic</strong>
                    </h3>
                    <a href="course.php?course_name=<?php echo"Math For Everyday Life"; ?> "><h4>Math For Everyday Life</h4></a>
					<a href="course.php?course_name=<?php echo"Thai Language For Everyday Life"; ?> "><h4>Thai Language For Everyday Life</h4></a>
					<a href="course.php?course_name=<?php echo"Biology For Everyday Life"; ?> "><h4>Biology For Everyday Life</h4></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
