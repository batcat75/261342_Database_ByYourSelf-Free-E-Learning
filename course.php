<?php 
	session_start();
	$c = oci_connect("TEST", "New25377", "localhost/XE");
?>
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
	<?php if(!isset($_SESSION['myusername'])){ ?>
	<!-- Not login -->
	
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
                <a class="navbar-brand" href="index.php">ByYourSelf</a>
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
	<?php }else {	$user_id = $_SESSION['user_id']; ?>
	<!-- With Login -->
	
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
                <a class="navbar-brand" href="learn.php">ByYourSelf</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="name_user"><i class="fa fa-user  fa-lg"></i>   <?php echo $_SESSION['myusername'];?> |</a>
                    </li>
					<?php if($_SESSION['user_type'] == 1){ ?>
						<li>
							<a href="tables.php" ><i class="fa fa-database  fa-lg"></i>Database Table</a>
						</li>
						<li>
							<a href="teacher_edit.php" ><i class="fa fa-edit  fa-lg"></i>Edit Topic</a>
						</li>
					<?php }else if($_SESSION['user_type'] == 2){ ?>
						<li>
							<a href="teacher_edit.php" ><i class="fa fa-edit  fa-lg"></i>Edit Topic</a>
						</li>
					<?php } ?>
                    <li>
                        <a href="logout.php" ><i class="fa fa-sign-out  fa-lg"></i>Logout</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
			
        </div>
        <!-- /.container -->
    </nav>
	<?php } ?>
	
	<?php 	if(!isset($_GET["course_name"])){ ?>
		<section id="about" class="about">
        <div class="container" >
            <div class="row">
				<div class="col-lg-1 text-center button-back-main">
				<?php
					if(isset($_SESSION['myusername'])){ ?>
						<a href="learn.php"><?php 
					}else{ ?>
						<a href="index.php"><?php 
					} ?>
							<div class="col-lg-12 text-center button-back">
								<h5><i class="fa fa-home"></i> Home</h5>
							</div>
						</a>
				</div>
                <div class="col-lg-10 text-center">
                    <h2><br>Oop!</h2>
					<hr class="small">
                    <br><p class="lead">You don't choose Topic.</p>
				</div>
            </div>
            <!-- /.row -->
        </div>
    </section>
	<?php } else { 
			$course_name = $_GET["course_name"];
	?>
    <!-- About -->
    <section id="about" class="about-course">
        <div class="container" >
            <div class="row">
				<div class="col-lg-1 text-center button-back-main">
					<?php
					if(isset($_SESSION['myusername'])){ ?>
						<a href="learn.php"><?php 
					}else{ ?>
						<a href="index.php"><?php 
					} ?>
							<div class="col-lg-12 text-center button-back">
								<h5><i class="fa fa-home"></i> Home</h5>
							</div>
						</a>
				</div>
                <div class="col-lg-10 text-center">
                    <h1><br><?php echo $course_name ?></h1>
					<hr class="md">
					<h4></h4>
				</div>
				<!-- Check Enrolment -->
					<?php
					if(isset($_SESSION['myusername'])){
						$enrol_check = 0;
						$s_enrol = oci_parse($c, "	select *
													from enrollment
													where mem_id = $user_id
													and course_id like (select course_id	
																		from course
																		where course_name = '$course_name')");
						$r_enrol = oci_execute($s_enrol);
						$Result_enrol = oci_fetch_array($s_enrol);
						if($Result_enrol >0){
							$enrol_check = 1; 
						}else {
							?>
							<a href="enrolment.php?course_name=<?php echo $course_name ;?>&user_id=<?php echo $user_id; ?>">
							<div class="col-lg-2 col-lg-offset-5 text-center course-enrol">
								<h3>Enrolment</h3>
							</div>
							</a>
							<div class="col-lg-10 col-lg-offset-1 text-center">
								<br><p> You don't enrol this topic, Click button to enrol or See some content/test.</p>
							</div>
							<?php
						}
					}
					if(isset($_GET['pre'])){
						echo "<div class=\"col-md-4 col-md-offset-4 text-center\"><h3 style=\"color:Red;\">Can't enroll this topic<br>Please check prerequisite.</h3></div>";
					}
					?>
					<!-- Check finish -->
					
					<!-- Course Detail -->
					<div class="col-md-12 text-center"><h4>Topic Detail</h4></div>
					<div class="col-md-12"> <hr></div>
					<div class="rowcourse">
						<div class="col-md-4 col-md-offset-1 text-center verticalLine">
							<h4><strong>ENROLLED STUDENT</strong><br>
							<?php
								$enrol = oci_parse($c, "select count(*)
														from enrollment
														where course_id LIKE (select course_id
																			  from course
																			  where course_name = '$course_name')");
								$r_enrol2 = oci_execute($enrol);
								$Result2 = oci_fetch_array($enrol);
								echo "<div class=\"col-md-12 text-center\"><h3>";
								echo $Result2[0];
								echo "</h3></div></h4>";
							?>
						</div>
						<div class="col-md-4 col-md-offset-2 text-center verticalLine">
							<h4><strong>PREREQUISITE</strong><br>
							<?php
								$pre = oci_parse($c, "select course_name
														from course
														where course_id in (select pre_course_id
																			  from pre_course
																			  where course_id in (select course_id
																									from course
																									where course_name LIKE '$course_name')																			  
																			  )");
								$r_pre = oci_execute($pre);
								$Result3 = oci_fetch_array($pre);
								echo "<div class=\"col-md-12 text-center\"><h3>";
								if($Result3 >0){
									do{
										echo "<div>";
										echo $Result3[0];
										echo "</div>";
									}while($Result3 = oci_fetch_array($pre));
								}else{
									echo "Non-prerequisite";
								}
								echo "</h3></div></h4>";
							?>
						</div>
					</div>
					<div class="col-md-12"> <hr></div>
					<!-- End Course Detail -->
			</div>
            <!-- /.row -->
		</div>
    </section>
	
    <!-- Services -->
    <!-- The circle icons use Font Awesome's stacked icon classes. For more information, visit http://fontawesome.io/examples/ -->
    <section id="services" class="services bg-primary">
        <div class="container">
			
            <div class="row text-center">
                <div class="col-lg-10 col-lg-offset-1">
                    <h2>List of Contents</h2>
                    <hr class="small">
                    <div class="row text-left">
						<?php
						$s = oci_parse($c, "select ctn.content_id,ctn.name,ctn.detail
											from  course crs, content ctn
											where  crs.course_id=ctn.course_id
											AND crs.course_name='$course_name'
											order by ctn.content_id");
						$r = oci_execute($s);
						$Result = oci_fetch_array($s);
						if($Result >0){
							if(isset($_SESSION['myusername'])&&$enrol_check==0){
							// With Login user & don't enrolment
								do{ 
									?>
									<a href="enrolment.php?content_name=<?php echo $Result[1] ?>&course_name=<?php echo $course_name ?>&user_id=<?php echo $user_id; ?>">
										<div class="show-content col-md-6 col-md-offset-3 ">
											<div class="col-md-5">
												<h4 style="margin-top:30px;margin-bottom:30px;"><?php echo $Result[1]; ?></h4>
											</div>
											<div class="col-md-2 col-md-offset-5">
												<i style="margin-top:20px;margin-bottom:10px;" class="fa fa-angle-right fa-2x"></i>
											</div>
										</div>
									</a>
								<?php
								}while($Result = oci_fetch_array($s)) ;
							}else{
							//Don't login user
								do{ 
									?>
									<a href="content.php?content_name=<?php echo $Result[1] ?>&course_name=<?php echo $course_name ?>">
										<div class="show-content col-md-6 col-md-offset-3 ">
											<div class="col-md-5">
												<h4 style="margin-top:30px;margin-bottom:30px;"><?php echo $Result[1]; ?></h4>
											</div>
											<div class="col-md-2 col-md-offset-5">
												<i style="margin-top:20px;margin-bottom:10px;" class="fa fa-angle-right fa-2x"></i>
											</div>
										</div>
									</a>
								<?php
								}while($Result = oci_fetch_array($s)) ;
							}?>
							<div style="margin-top:30px;"class="col-md-6 col-md-offset-3 text-center">
								<h4>Test Topic's knowledge</h4>
								<hr class="md">
							</div>
							<?php 
							if(isset($_SESSION['myusername'])&&$enrol_check==0){
							// With Login user & don't enrolment ?>
								<a href="enrolment.php?course_name=<?php echo $course_name ?>&user_id=<?php echo $user_id; ?>&test=1">
							<?php 
							}else{ 
							// With Login user enrolled ?>
								<a href="test.php?course_name=<?php echo $course_name ?>"><?php 
							} ?>
								<div class="course-test-button col-md-6 col-md-offset-3">
									<div class="col-md-5">
										<p style="margin-top:30px;margin-bottom:30px;"><b>Test</b></p>
									</div>
									<div class="col-md-2 col-md-offset-5">
											<i style="margin-top:20px;margin-bottom:10px;" class="fa fa-tasks fa-2x"></i>
									</div>
								</div>
							</a>
						<?php
						}else {
						?>
							<div class="col-md-6 col-md-offset-3 text-center">
								<div class="service-item">
									<h3><i class="fa fa-exclamation-triangle"></i>  Oops! Something wrong</h3>
									<h4>This Topic is don't have content. Contact your admin</h4>
								</div>
							</div>
						<?php } ?>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.col-lg-10 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>
	<?php } ?>
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

    <!-- Custom Theme JavaScript -->
	<!-- Tab toggle -->
	<script>
		$('#myTab a').click(function (e) {
			e.preventDefault()
			$(this).tab('show')
		})
		$(function () {
			$('#myTab a:last').tab('show')
		})
	</script>

</body>

</html>
