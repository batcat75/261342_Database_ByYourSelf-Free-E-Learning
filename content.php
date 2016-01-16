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
	<?php if(!isset($_SESSION['myusername'])){ 
			$course_name=$_GET['course_name'];
			
			if($course_name=='Math For Everyday Life'){
			
			}else
			if($course_name=='Thai Language For Everyday Life'){
			
			}else
			if($course_name=='Biology For Everyday Life'){
				
			}else{
				header("location:index.php");
			}
	?>
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
	<?php }else { 
		$course_name=$_GET['course_name'];
	?>
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
	
	<?php 	if(!isset($_GET["content_name"])){ ?>
		<section id="about" class="about">
        <div class="container" >
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2><br><i class="fa fa-exclamation-triangle"></i>  Oop!</h2>
					<hr class="small">
                    <br><p class="lead">You don't choose content.</p>
            </div>
            <!-- /.row -->
        </div>
		</section>
	<?php } else { 	
		$content_name = $_GET["content_name"];
	?>
	<section class="about-content">
        <div class="container" >
            <div class="row">
				<div class="col-lg-1 text-center button-back-main">
					<a href="course.php?course_name=<?php echo $course_name; ?>">
						<div class="col-lg-12 text-center button-back">
							<h5><i class="fa fa-reply"></i> Back</h5>
						</div>
					</a>
				</div>
                <div class="col-lg-10 text-center">
                    <h2><br><?php echo $course_name ;?></h2>
					<hr class="small">
                    <p class="lead"><?php echo $content_name ;?></p>
				</div>
            <!-- /.row -->
        </div>
	</section>
    <!-- About -->
    <section class="content" >
        <div class="container" >
            <div class="row">
				<div class="col-lg-12 content-main">
					<div class="col-lg-3 content-list">
					   <?php
							$s = oci_parse($c, "select ctn.content_id,ctn.name,ctn.detail
												from  course crs, content ctn
												where  crs.course_id=ctn.course_id
												AND crs.course_name='$course_name'
												order by ctn.content_id");
							$r = oci_execute($s);
							$Result = oci_fetch_array($s);
							if($Result > 0){ 
								do{ ?>
									<a href="content.php?content_name=<?php echo $Result[1] ?>&course_name=<?php echo $course_name ?>">
										<div class="content-button<?php if($content_name== $Result[1]){echo "-action";}?> col-md-12">
											<div class="col-md-12">
												<h4 style="margin-top:20px;margin-bottom:20px;"><?php echo $Result[1]; ?></h4>
											</div>
										</div>
									</a>
								<?php
								}while($Result = oci_fetch_array($s)) ?>
								
								<a href="test.php?course_name=<?php echo $course_name ?>">
										<div class="test-button col-md-12">
											<div class="col-md-12">
												<p style="margin-top:20px;margin-bottom:20px;">Test Topic's Knowledge</p>
											</div>
										</div>
								</a>
						<?php }else { ?>
						
						<?php } ?>
					</div>
					<!-- /.col-lg-4 -->
					<?php 
						$s = oci_parse($c, "select detail
											from  content
											where  name = '$content_name'");
						$r = oci_execute($s); 
						$Result = oci_fetch_array($s);
					?>
						<div class="col-lg-8 content-data">
						   <iframe src="<?php echo $Result[0] ?>/embed?start=false&loop=false&delayms=3000" frameborder="0" width="830" height="492" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
						</div>
						<!-- /.col-lg-8 -->
				</div>
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
