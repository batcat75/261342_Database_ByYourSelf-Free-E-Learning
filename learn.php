<?php session_start();
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
	
    <!-- About -->
    <section id="about" class="about">
        <div class="container" >
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2><br>Welcome Back!</h2>
					<hr class="small">
					<div class "col-md-12">
						<div class="col-md-4 col-md-offset-4 reccourse text-center">
							<div class="col-md-12">
								<div class="service-item">
									<h4><strong><em>Recommended Course</em></strong></h4>
									<span class="fa-stack fa-4x">
									<i class="fa fa-circle fa-stack-2x"></i>
									<i class="fa fa-superscript fa-stack-1x text-primary"></i>
									</span>
									<h3>
										<strong>Math For Everyday Life</strong>
									</h3>
									<!-- Check Enrolment -->
									<?php
									if(isset($_SESSION['myusername'])){
										$user_id=$_SESSION['user_id'];
										$enrol_check = 0;
										$s_enrol = oci_parse($c, "	select *
																	from enrollment
																	where mem_id = $user_id
																	and course_id = 200100");
										$r_enrol = oci_execute($s_enrol);
										$Result_enrol = oci_fetch_array($s_enrol);
										if($Result_enrol >0){ ?>
											<a href="course.php?course_name=Math For Everyday Life&course_id=200100" class="btn btn-rec btn-lg">Continue</a> <?php
										}else {
											?>
											<a href="course.php?course_name=Math For Everyday Life&course_id=200100" class="btn btn-rec btn-green btn-lg">
												Enrolment
											</a>
											<?php
										}
									}else{
									?>
									<!-- Check finish -->
										<a href="course.php?course_name=Math For Everyday Life&course_id=200100" class="btn btn-rec btn-lg">Learn</a>
									<?php } ?>
									<h5>We have many topics below, <a class="click-slide" id="myButton"href="#services">Click here to see more.</a></h5>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 ">
						<br><p class="lead">See Your Process</p>
						<div role="tabpanel">
							<!-- Nav tabs -->
							<ul class="nav nav-tabs " role="tablist">
								<li role="presentation" class="active"><a href="#in-process" aria-controls="in-process" role="tab" data-toggle="tab">In-Process Learning</a></li>
								<li role="presentation"><a href="#complete" aria-controls="complete" role="tab" data-toggle="tab">Complete Learning</a></li>
							</ul>
							<!-- Tab panes -->
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="in-process"><br>			
								<?php 
									$user_id = $_SESSION['user_id'] ;
									$s = oci_parse($c, "select e.mem_id,e.flag_pass,c.course_name,c.course_id
														from enrollment e, course c
														where mem_id = $user_id
														and flag_pass=0
														and c.course_id = e.course_id");
									$r = oci_execute($s);
									$Result = oci_fetch_array($s);
									if($Result > 0){
								?>
									<div class="row">
										<div class="col-md-4 col-md-offset-1 text-left">
											<h4><strong>Course Name</strong></h4>
										</div>
										<div class="col-md-3 text-left"></h4>
											<h4><strong>Score</strong>
										</div>
										<div class="col-md-2 col-md-offset-1">
											<h4><strong>Learning</strong></h4>
										</div>
										<div class="col-md-12"> <hr></div>
										
										<!-- processing topic -->
										<?php
										do{?>
											<div class="col-md-4 col-md-offset-1 text-left">
												<h4><strong><?php 
															echo $Result["COURSE_NAME"];
															$course_name=$Result["COURSE_NAME"];
														?> 
												</strong></h4>
											</div>
											<div class="col-md-3 text-left">
											<?php 
												$score_data = oci_parse($c, "select max(t.score)
																			from test_history t,course c
																			where mem_id = $user_id
																			and  t.course_id = $Result[3]");
												$score_r = oci_execute($score_data);
												$score_Result = oci_fetch_array($score_data);
												if(count($score_Result) > 0){ ?>
													<h4><div class="progress">
														<div class="progress-bar 
														<?php 
															if($score_Result[0]>=50){
																echo "progress-bar-info";}
															else if($score_Result[0]>=25){
																echo "progress-bar-warning";}
															else {
																echo "progress-bar-danger";}
														?>
														" role="progressbar" aria-valuenow="<?php echo $score_Result[0]; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $score_Result[0]; ?>%;">
															<?php echo $score_Result[0]; ?>%
														</div>
													</div></h4>
												<?php
												}else{
												?>
												<h4><div class="progress">
													<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
														0%
													</div>
												</div></h4>
											<?php } ?>
											</div>
											<div class="col-md-1 text-left">
												<h6><p>Avg:
												<?php 
													$score_avg = oci_parse($c, "select  round(avg(max(score)))
																				from test_history
																				where course_id = $Result[3]
																				group by mem_id");
													$avg_r = oci_execute($score_avg);
													$avg_Result = oci_fetch_array($score_avg);
													if($avg_Result[0] > 0){
														echo $avg_Result[0];
													}else{
														echo "0";
													}
												?>	
												% Top:
												<?php 
													$score_max = oci_parse($c, "select  max(score)
																				from test_history
																				where course_id = $Result[3]");
													$max_r = oci_execute($score_max);
													$max_Result = oci_fetch_array($score_max);
													if($max_Result[0] > 0){
														echo $max_Result[0];
													}else{
														echo "0";
													}
												?>	
												%</p></h6>
											</div>
											<div class="col-md-2 text-center">
												<h5><a href="course.php?course_name=<?php echo $Result["COURSE_NAME"]; ?>"><i class="fa fa-caret-square-o-right fa-2x"></i></a></h5>
											</div>
										<?php
										}while($Result = oci_fetch_array($s)) 
										?>
									</div>
									<?php
									}else{ ?>
										<div class="row">
											<h4>You have not enrolment topic.</h4>
											<h5>Select some one.</h5>
										</div>
									<?php } ?>
								</div>
								<div role="tabpanel" class="tab-pane" id="complete"><br>
								<?php 
									$user_id = $_SESSION['user_id'] ;
									$s = oci_parse($c, "select e.mem_id,e.flag_pass,c.course_name,c.course_id
														from enrollment e, course c
														where mem_id = $user_id
														and flag_pass=1
														and c.course_id = e.course_id");
									$r = oci_execute($s);
									$Result = oci_fetch_array($s);
									if($Result > 0){
								?>
									<div class="row">
										<div class="col-md-4 col-md-offset-1 text-left">
											<h4><strong>Course Name</strong></h4>
										</div>
										<div class="col-md-3  text-left"></h4>
											<h4><strong>Score</strong>
										</div>
										<div class="col-md-2 col-md-offset-1">
											<h4><strong>Re-Learning</strong></h4>
										</div>
										<div class="col-md-12"> <hr></div>
										<!-- complete topic -->
										<?php
										do{?>
											<div class="col-md-4 col-md-offset-1 text-left">
												<h4><strong><?php 
															echo $Result["COURSE_NAME"];
															$course_name = $Result["COURSE_NAME"];
														?> 
												</strong></h4>
											</div>
											<div class="col-md-3 text-left">
											<?php 
												$score_data = oci_parse($c, "select max(t.score)
																			from test_history t,course c
																			where mem_id = $user_id
																			and  t.course_id = $Result[3]");
												$score_r = oci_execute($score_data);
												$score_Result = oci_fetch_array($score_data);
												if(count($score_Result) > 0){ ?>
													<h4><div class="progress">
														<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $score_Result[0]; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $score_Result[0]; ?>%;">
															<?php echo $score_Result[0]; ?>%
														</div>
													</div></h4>
												<?php
												}else{
											?>
											<h4>No data</h4>
											<?php } ?>
											</div>
											<div class="col-md-1 text-left">
												<h6><p>Avg:
												<?php 
													$score_avg = oci_parse($c, "select  round(avg(max(score)))
																				from test_history
																				where course_id = $Result[3]
																				group by mem_id");
													$avg_r = oci_execute($score_avg);
													$avg_Result = oci_fetch_array($score_avg);
													if($avg_Result[0] > 0){
														echo $avg_Result[0];
													}else{
														echo "0";
													}
												?>	
												% Top:
												<?php 
													$score_max = oci_parse($c, "select  max(score)
																				from test_history
																				where course_id = $Result[3]");
													$max_r = oci_execute($score_max);
													$max_Result = oci_fetch_array($score_max);
													if($max_Result[0] > 0){
														echo $max_Result[0];
													}else{
														echo "0";
													}
												?>	
												%</p></h6>
											</div>
											<div class="col-md-2  text-center">
												<h5><a href="course.php?course_name=<?php echo $Result["COURSE_NAME"]; ?>"><i class="fa fa-caret-square-o-right fa-2x"></i></a></h5>
											</div>
										<?php
										}while($Result = oci_fetch_array($s)) 
										?>
									</div>
									<?php
									}else{ ?>
										<div class="row">
											<h4>You have not completed topic.</h4>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
                </div>
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
                    <h2>Topic Selection</h2>
                    <hr class="small">
                    <div class="row">
						<?php
						$s = oci_parse($c, "select course_id,course_name,detail
											from course ");
						$r = oci_execute($s);
						while($Result = oci_fetch_array($s)) {?>
							<div class="col-md-4 col-sm-6">
								<div class="service-item">
									<span class="fa-stack fa-4x">
									<i class="fa fa-circle fa-stack-2x"></i>
									<?php if($Result["COURSE_ID"] == 100100){ ?>
										<i class="fa fa-book fa-stack-1x text-primary"></i>
									<?php }else if($Result["COURSE_ID"] == 200100){ ?>
										<i class="fa fa-superscript fa-stack-1x text-primary"></i>
									<?php }else if($Result["COURSE_ID"] == 300100){ ?>
										<i class="fa fa-tree fa-stack-1x text-primary"></i>
									<?php }else if($Result["COURSE_ID"] == 400100){ ?>
										<i class="fa fa-rocket fa-stack-1x text-primary"></i>
									<?php }else if($Result["COURSE_ID"] == 700500){ ?>
										<i class="fa fa-code-fork fa-stack-1x text-primary"></i>
									<?php }else if($Result["COURSE_ID"] == 200200){ ?>
										<i class="fa fa-puzzle-piece fa-stack-1x text-primary"></i>
									<?php }else { ?>
										<i class="fa fa-cloud fa-stack-1x text-primary"></i>
									<?php } ?>
								</span>
									<h4>
										<strong><?php echo $Result["COURSE_NAME"]?></strong>
									</h4>
									<p><?php echo $Result["DETAIL"]?></p>
									<a href="course.php?course_name=<?php echo $Result["COURSE_NAME"] ?>&course_id=<?php echo $Result["COURSE_ID"] ?>" class="btn btn-light">Learn</a>
								</div>
							</div>
						<?php
						}
						?>
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
	
	<script>
	// Scrolls to the selected menu item on the page
    $(function() {
        $('#myButton').click(function() {
		   if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {

                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top
                    }, 1000);
                    return false;
                }
            }
		});
    });
	</script>
</body>

</html>
