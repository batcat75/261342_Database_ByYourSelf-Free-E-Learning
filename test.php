<?php 
	session_start();
	if(!isset($_SESSION['myusername'])){
		header("location:main_login.php");
	}
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
	
	<?php 	if(!isset($_GET["course_name"])){ ?>
		<section id="about" class="about">
        <div class="container" >
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2><br><i class="fa fa-exclamation-triangle"></i>  Oop!</h2>
					<hr class="small">
                    <br><p class="lead">You don't choose Test's Topic.</p>
            </div>
            <!-- /.row -->
        </div>
		</section>
	<?php } else { 	
		$course_name=$_GET['course_name'];
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
                    <p class="lead">Test</p>
				</div>
            <!-- /.row -->
        </div>
	</section>
    <!-- About -->
    <section class="content" >
        <div class="container" >
            <div class="row">
				<div class="col-lg-8 col-lg-offset-2 content-main">
					 <?php
						$s = oci_parse($c, "select q.question,q.question_id,q.course_id
											from questions q, course c
											where c.course_name = '$course_name'
											and c.course_id = q.course_id
											order by q.question_id");
						$r = oci_execute($s);
						$Result = oci_fetch_array($s);
						if($Result > 0){ 
						$choice_num=1;
						echo "<form id=\"testForm\" method=\"post\" class=\"form-horizontal\" action=\"testCheck.php\">"; ?>
						<input type ='hidden' value='<?php echo $Result[2] ?>' name='course_id'>
						<?php do{ ?>
							<div class=" col-md-8 col-lg-offset-2 content-button-question">
								<div class="col-md-8 col-lg-offset-2">
									<h4 style="margin-top:20px;margin-bottom:20px;"><?php echo $choice_num; ?>) <?php echo $Result[0]; ?></h4>
								</div>
									<?php
									$sc = oci_parse($c, "select c.detail,c.choice_id
														from choice c,questions q
														where q.question_id = $Result[1] 
														and q.question_id = c.question_id
														order by c.choice_id");
									$rc = oci_execute($sc);
									$Result_choice = oci_fetch_array($sc);
									if($Result_choice > 0){ 
									do{ ?>
										<div class=" col-md-8 col-lg-offset-3 ">
										<div class="col-md-12 content-button">
											<div class="radio">
												<label>
													<input type ='hidden' value='<?php echo $Result[1] ?>' name='question<?php echo $choice_num?>'>
													<h4><input type="radio" name="choice<?php echo $choice_num?>" value="<?php echo $Result_choice[1]?>" /> <?php echo $Result_choice[0]; ?></h4>
												</label>
												</label>
											</div>
											</div>
										</div>
									<?php
									}while($Result_choice = oci_fetch_array($sc)) ?>
									<?php } ?>
							</div>
						<?php
							$choice_num++;
						}while($Result = oci_fetch_array($s)) ?>
						<?php $choice_num--; ?>
						<input type ='hidden' value='<?php echo $choice_num ?>' name='choice_num'>
						<input type ='hidden' value='<?php echo $course_name ?>' name='course_name'>
						<div class=" col-md-12">
							<div class="col-sm-8 col-sm-offset-5">
								<br>
								<!-- Do NOT use name="submit" or id="submit" for the Submit button -->
								<button type="submit" class="btn btn-success btn-lg">Submit</button>
							</div>
                        </div>
						<?php 
						echo "</form>";
						}else { ?>
						
						
						<?php } ?>
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
