<?php 
	ob_start();
	session_start();
	if(!isset($_SESSION['myusername'])){
		header("location:index.php");
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
	
	<?php 	if(!isset($_POST["course_name"])){ ?>
		<section id="about" class="about">
        <div class="container" >
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2><br>Oop!</h2>
					<hr class="small">
                    <br><p class="lead">Some thing wrong. Contact your admin.</p>
            </div>
            <!-- /.row -->
        </div>
    </section>
	<?php } else { 
			$choice_num = $_POST["choice_num"];
			$course_name = $_POST["course_name"];
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
				<div class="col-lg-1 text-center button-back-main">
					<a href="learn.php">
						<div class="col-lg-12 text-center button-back">
							<h5><i class="fa fa-home"></i> Home</h5>
						</div>
					</a>
				</div>
                <div class="col-lg-8 text-center">
                    <h2><br><?php echo $course_name ;?></h2>
					<hr class="small">
                    <p class="lead">Your Score</p>
				</div>
            <!-- /.row -->
        </div>
	</section>
    <!-- About -->
    <section class="content" >
        <div class="container" >
            <div class="row">
				<div class="col-lg-12 content-main">
					<div class="col-lg-12 content-list">
					<?php
						$score = 0;
						for($i = 1; $i <= $choice_num; $i++){
							$tmp_question_id = 'question'.$i ;
							$tmp_question_id=isset($_POST[$tmp_question_id])?$_POST[$tmp_question_id]:' ';
							$s = oci_parse($c, "select a.choice_id
												from answer a
												where a.question_id = $tmp_question_id");
							$r = oci_execute($s);
							$Result = oci_fetch_array($s); 
							$tmp_choice_id = 'choice'.$i ;
							$tmp_choice_id=isset($_POST[$tmp_choice_id])?$_POST[$tmp_choice_id]:' ';
							if($tmp_choice_id==$Result[0]){
								$score++;
							}
						} 
						$score=($score / $choice_num)*100;
						
						$course_id=isset($_POST['course_id'])?$_POST['course_id']:' ';
						$t = oci_parse($c, "INSERT INTO TEST_HISTORY Values (test_history_seq.nextval,$user_id,$course_id,sysdate,$score)");
						$r = oci_execute($t);
						
						
						
						?>
						<h1 class="text-center"> TEST RESULT </h1>
						<h1 class="text-center" style="color: Red;"><strong><?php echo $score ?> % </strong></h1><br>
						<?php
							if($score >= 80){
								echo "<div class=\"col-lg-8 text-center col-lg-offset-2\" style=\"background-color: White;\"><h3>Congratulations, you pass this topic.</h3></div>";
								
								$pass = oci_parse($c, "update enrollment
													set FLAG_PASS = 1
													where mem_id = $user_id
													and course_id = $course_id");
								$r_pass = oci_execute($pass); 
							}else if($score >= 70){
								echo "<div class=\"col-lg-8 text-center col-lg-offset-2\" style=\"background-color: White;\"><h3>You need to score 80 percent or higher to pass this topic. So close!</h3></div>";
							}else if($score >= 50){
								echo "<div class=\"col-lg-8 text-center col-lg-offset-2\" style=\"background-color: White;\"><h3>You need to score 80 percent or higher to pass this topic. :D</h3></div>";
							}else {
								echo "<div class=\"col-lg-8 text-center col-lg-offset-2\" style=\"background-color: White;\"><h3>You need to score 80 percent or higher to pass this topic. Try Again?</h3></div>";
							}
						?>
						
					</div>
					<div class="col-lg-4 col-lg-offset-4 text-center button-back-main">
						<a href="learn.php">
							<div class="col-lg-12 text-center button-back">
								<h4><i class="fa fa-sitemap"></i> Back to main page, Learn other topic</h4>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
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
