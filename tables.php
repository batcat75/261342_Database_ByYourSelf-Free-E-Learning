<?php
	session_start();
	if(!isset($_SESSION['myusername'])){
		header("location:main_login.php");
	}
	if($_SESSION['user_type'] != 1){
			header("location:learn.php");
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
                <a class="navbar-brand" href="learn.php"> ByYourSelf</a>
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
						Select your table 
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
		<?php
		}else{
			$tableName = $_SESSION['Table'];
			$s = oci_parse($c, "SELECT column_name 
								FROM ALL_CONS_COLUMNS A JOIN ALL_CONSTRAINTS C  
									ON A.CONSTRAINT_NAME = C.CONSTRAINT_NAME 
								WHERE C.TABLE_NAME = UPPER('$tableName')
								AND C.CONSTRAINT_TYPE = 'P'");
			$r = oci_execute($s);
			$Num_key = oci_fetch_all($s, $Result);
			$r = oci_execute($s);
			$row_key = oci_fetch_array($s);
			$key1 = $row_key[0];
			if ($Num_key>1){
				$row_key = oci_fetch_array($s);
				$key2 = $row_key[0];
			}
			//-- find primary key --//
			
			if($tableName=='PRE_COURSE'){
				$s = oci_parse($c, "select p.course_id,c.course_name,p.pre_course_id,cn.course_name
									from pre_course p,course c,course cn
									where p.course_id = c.course_id 
									and p.pre_course_id = cn.course_id
									order by p.course_id");
			}else{
				if($Num_key==1){
					$s = oci_parse($c, "select * from $tableName order by $key1");
				}else{
					$s = oci_parse($c, "select * from $tableName order by $key1,$key2");
				}
			}
			$r = oci_execute($s);
			$ncols = oci_num_fields($s);
			//-- prepare to keep data --//
		?>
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo $tableName?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo "<a href=addForm.php><i class=\"fa fa-plus-square fa-fw\"></i>Add Data</a>";?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr><?php
											for ($i = 1; $i <= $ncols; ++$i) {
												$colname = oci_field_name($s, $i);
												echo "  <th>".htmlentities($colname, ENT_QUOTES)."</th>";
											}
											echo "  <th><b>edit</b></th>";
											echo "  <th><b>delete</b></th>";
										?>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
                                        while($row = oci_fetch_array($s)) {
											echo "<tr>";
											for($i = 0; $i < $ncols; $i++) {
												echo "<td>" .$row[$i]. "</td>";
											}
											if($tableName=='PRE_COURSE'){
												echo "  <td><a href=editRecordForm.php?value_key1=".$row[0]."&value_key2=".$row[2]."&table=".$tableName."><i class=\"fa fa-edit fa-fw\"></i></td></td>";
												echo "<td><a href=\"deleteRecord.php?value_key1=".$row[0]."&value_key2=".$row[2]."&table=".$tableName."\"onclick=
													\"return confirm('Are you sure, you want to delete?')\"><i class=\"fa fa-times fa-fw\"></i></a></td>";
											}else if($Num_key==1){
												echo "  <td><a href=editRecordForm.php?value_key1=".$row[0]."&table=".$tableName."><i class=\"fa fa-edit fa-fw\"></i></td>";
												echo "<td><a href=\"deleteRecord.php?value_key1=".$row[0]."&table=".$tableName."\"onclick=
													\"return confirm('Are you sure, you want to delete?')\"><i class=\"fa fa-times fa-fw\"></i></a></td>";
											}else{
												echo "  <td><a href=editRecordForm.php?value_key1=".$row[0]."&value_key2=".$row[1]."&table=".$tableName."><i class=\"fa fa-edit fa-fw\"></i></td></td>";
												echo "<td><a href=\"deleteRecord.php?value_key1=".$row[0]."&value_key2=".$row[1]."&table=".$tableName."\"onclick=
													\"return confirm('Are you sure, you want to delete?')\"><i class=\"fa fa-times fa-fw\"></i></td></a></td>";
											}
											echo "</tr>";
									}?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                            <div class="well">
								<p class="text-muted">ByYourSelf</p>
								<p class="text-muted">Copyright &copy; CPE#21 ,CMU</p>
                            </div>
                        </div>
                        <!-- /.panel-body -->
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

</body>

</html>
