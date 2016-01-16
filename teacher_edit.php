<?php 
	session_start();
	if(!isset($_SESSION['myusername'])){
		header("location:main_login.php");
	}
	$user_id=$_SESSION['user_id'];
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
		
		<link rel="stylesheet" href="dist/css/bootstrapValidator.css"/>

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
	<section class="about-content">
        <div class="container" >
            <div class="row">
				<div class="col-lg-1 text-center button-back-main">
					<a href="learn.php">
						<div class="col-lg-12 text-center button-back">
							<h5><i class="fa fa-home"></i> Home</h5>
						</div>
					</a>
				</div>
                <div class="col-lg-10 text-center">
                    <h2><br>Welcome to Teacher Page</h2>
					<p class="lead">See your topic<p>
				</div>
            <!-- /.row -->
        </div>
	</section>
    <!-- About -->
    <section class="content" >
        <div class="container" >
            <div class="row">
				<div class="col-lg-12 content-main">
					<div class="col-lg-3 col-lg-offset-1 content-list">
						<div class="col-md-12 text-center"><h4><ins>Your Topic</ins></h4></div>
						<?php 
						if(isset($_GET["course"])){
							$course_name=$_GET['course'];
						}
						$s_admin = oci_parse($c, "	select course_name
													from course
													where course_id in (select course_id
																		from course_admin
																		where mem_id = $user_id)");
						$r_admin = oci_execute($s_admin);
						$Result_admin = oci_fetch_array($s_admin);
						if($Result_admin >0){ 
							do{?>
								<a href="teacher_edit.php?course=<?php echo $Result_admin[0]; ?>">
									<div class="course-button<?php if(isset($_GET["course"])){if($course_name==$Result_admin[0]){echo "-action";}}?> col-md-12">
										<div class="col-md-12">
											<h4 style="margin-top:20px;margin-bottom:20px;"><?php echo $Result_admin[0]; ?></h4>
										</div>
									</div>
								</a><?php
							}while($Result_admin = oci_fetch_array($s_admin));
						}else{ 
							echo "You don't have can edit topic";
						}?>
						<a href="addForm_teacher_course.php">
							<div class="course-button col-md-12">
								<div class="col-md-12">
									<h4 style="margin-top:20px;margin-bottom:20px;"><i class="fa fa-plus-square"></i> Create new topic</h4>
								</div>
							</div>
						</a>
					</div>
					
					<div class="col-lg-8 content-data">
						<br>
					   <div class="col-md-12 text-left">Your Content <?php if(isset($_GET["course"])){echo " in "; echo $course_name;} ?></div>
					   <div class="col-md-10 col-md-offset-1"><br>
						   <?php
						   if(isset($_GET["course"])){
								$s_admin_content = oci_parse($c, "	select name, detail
																	from content
																	where course_id in (select course_id
																						from course
																						where course_name like '$course_name')
																	order by content_id");
								$r_admin_content = oci_execute($s_admin_content);
								$Result_content = oci_fetch_array($s_admin_content);
								if($Result_content >0){
									do{?>
										<a href="<?php echo $Result_content[1]; ?>" target="_blank">
											<div class="link-button col-md-12">
												<div class="col-md-12">
													<h4 style="margin-top:20px;margin-bottom:20px;"><?php echo $Result_content[0]; ?></h4>
												</div>
											</div>
										</a><?php
									}while($Result_content = oci_fetch_array($s_admin_content));
								}else{
									echo"<br><h4>This topic don't has content.</h4>";
								}
						   }else{
							echo "<h4>Please select topic.</h4>";
						   }
						   ?>
					   </div>
					</div>
					
				</div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>
	<!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-right">
                    <h5 class="text-muted">ByYourSelf</h5>
                    <p class="text-muted">Copyright &copy; CPE#21 ,CMU</p>
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
