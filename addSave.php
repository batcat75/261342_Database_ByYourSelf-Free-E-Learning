<?php
	ob_start();
	session_start();
	if(!isset($_SESSION['myusername'])){
		header("location:main_login.php");
	}
	$c = oci_connect("TEST", "New25377", "localhost/XE");
	$s = oci_parse($c, "select table_name from user_tables order by table_name");
	$r = oci_execute($s);
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
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="css/plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="learn.php"> By Your Self</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
			
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="learn.php"><i class="fa fa-university fa-fw"></i> Main Page</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-table fa-fw"></i> Tables<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
								<?php
								while (($row = oci_fetch_array($s, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
									foreach ($row as $item) {
										echo"<li>";
										echo"<a href=change_session.php?Table=".$item.">$item</a>";
										echo "</li>";
									}
								}
								?>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
		<?php
		if(!isset($_SESSION['Table'])){
		?>
			<div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Welcome</h1>
						Select your table before add data.
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
		<?php
		}else{
			$tableName = $_SESSION['Table'];
			$n=isset($_POST['n'])?$_POST['n']:' '; 
			$table=isset($_POST['table'])?$_POST['table']:' '; 

			$c = oci_connect("TEST", "New25377", "localhost/XE");
			$s = oci_parse($c, "SELECT column_name 
									FROM ALL_CONS_COLUMNS A JOIN ALL_CONSTRAINTS C  
										ON A.CONSTRAINT_NAME = C.CONSTRAINT_NAME 
									WHERE C.TABLE_NAME = UPPER('$table')
									AND C.CONSTRAINT_TYPE = 'P'");
			$r = oci_execute($s);
			$successful = 0;
			$Num_key = oci_fetch_all($s, $Result);
				
			$r = oci_execute($s);
			if($Num_key==1){
				$row_key = oci_fetch_array($s);
				$key1 = $row_key[0];
				$s_test = oci_parse($c, "select * from ".$table." where ".$key1." = ".$_POST['addtext0']."");
			}else{
				$row_key = oci_fetch_array($s);
				$key1 = $row_key[0];
				$row_key = oci_fetch_array($s);
				$key2 = $row_key[0];
				$s_test = oci_parse($c, "select * from ".$table." 
										where ".$key1." = ".$_POST['addtext0']."
										and ".$key2." = ".$_POST['addtext1']."");
			}
			//-- prepare to add data --//
			?>
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo $tableName?> : Add </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
						<?php
						@$r_test = oci_execute($s_test);	
						if($r_test){
							$count = oci_fetch_array($s_test, OCI_ASSOC);
							if($count){
								echo "<div class=\"panel-heading\"><i class=\"fa fa-exclamation-triangle fa-fw\"></i>Fail to Add!</div>";		
								if($Num_key==1){
									echo "<div class=\"panel-body\">$key1 :".$_POST['addtext0']." is Exist </div>";
								}else{
									echo "<div class=\"panel-body\">$key1 :".$_POST['addtext0']." and $key2 :".$_POST['addtext0']." are Exist </div>";
								}
								echo "<br>";
								echo "Please Change Your values";
							}else{
								if(($table!='ENROLLMENT')&&($table!='TEST_HISTORY')){
									$str = '';
									for($j=0;$j<$n;$j++){
										$tmp = 'addtext'.$j;
										$tmp=isset($_POST[$tmp])?$_POST[$tmp]:' '; 
										if($j==($n-1)){
											$str .="'".$tmp."'";
										}else{
											$str .="'".$tmp."'".", ";
										}
									}
								}else{
									$str = '';
									for($j=0;$j<$n;$j++){
										$tmp = 'addtext'.$j;
										$tmp=isset($_POST[$tmp])?$_POST[$tmp]:' '; 
										if($j==3){
											if($table=='ENROLLMENT'){
												$str .="to_char(to_date('".$tmp."','yyyy-mm-dd'),'dd-Mon-yyyy')";
											}else{
												$str .="to_char(to_date('".$tmp."','yyyy-mm-dd'),'dd-Mon-yyyy'),";
											}
										}else if($j==($n-1)){
											$str .="'".$tmp."'";
										}else{
											$str .="'".$tmp."'".", ";
										}
									}
								}
								//echo $str;
								$s = oci_parse($c, "INSERT INTO ".$table." Values (".$str.")");
								$r = oci_execute($s);
								if($r){
									echo "<div class=\"panel-heading\"><i class=\"fa fa-check fa-fw\"></i>Add Successful</div>";
									$successful = 1;
								}else{
									echo "<div class=\"panel-heading\"><i class=\"fa fa-exclamation-triangle fa-fw\"></i>Fail to Add</div>";
									echo "<div class=\"panel-body\">Make sure your data are correct (Key don't exist)</div>";
								}
							}
						}else{
							echo "<div class=\"panel-heading\"><i class=\"fa fa-exclamation-triangle fa-fw\"></i>Fail to add!</div>";
						}
						if($successful == 1){
							header( "refresh:5;url=tables.php" );
							echo"<div class=\"panel-body\">You will be back to $table in <span id=\"counter\">5</span> second(s).</div>";
						}
						?>
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
			<?php } ?>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').dataTable();
    });
    </script>
		
	<!--<script type="text/javascript" src="vendor/jquery/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="vendor/bootstrap/js/bootstrap.min.js"></script> -->
	<script type="text/javascript" src="dist/js/bootstrapValidator.js"></script>
	<script type="text/javascript">
		function countdown() {
			var i = document.getElementById('counter');
			if (parseInt(i.innerHTML)<=1) {
				//break;
			}
			i.innerHTML = parseInt(i.innerHTML)-1;
		}
		setInterval(function(){ countdown(); },1000);
	</script>     
</body>

</html>
