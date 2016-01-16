<?php
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
	<!--<link href="table.css" rel="stylesheet">
	<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css"/>-->
	<link rel="stylesheet" href="dist/css/bootstrapValidator.css"/>

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
			$s = oci_parse($c, "select * from $tableName ");
			$r = oci_execute($s);
			$ncols = oci_num_fields($s);
	
			$check_table_detail = oci_parse($c, "select column_name,data_type,data_length,nullable 
												from USER_TAB_COLUMNS
												where table_name = UPPER('$tableName')");
			$check_r = oci_execute($check_table_detail);
		
			$check_foreign_key = oci_parse($c, "select d.table_name,e.column_name
												from user_constraints d,all_cons_columns e,
												(select c.constraint_name,
														c.r_constraint_name,
														c.table_name
														from user_constraints c 
														where table_name=UPPER('$tableName')
														and constraint_type='R') b
												where d.constraint_name=b.r_constraint_name
												and e.constraint_name=b.constraint_name");
			$check_fk = oci_execute($check_foreign_key);
			$Num_fk = oci_fetch_all($check_foreign_key, $Result);
			
			if($Num_fk>0){
				$check_fk = oci_execute($check_foreign_key);
				for($k=0;$k<=$Num_fk;$k++){
					$row_fk = oci_fetch_array($check_foreign_key);
					$fk[$k] = $row_fk[0];
					$fk_colName[$k] = $row_fk[1];
					$find_fk_key = oci_parse($c, "SELECT column_name 
									FROM ALL_CONS_COLUMNS A JOIN ALL_CONSTRAINTS C  
										ON A.CONSTRAINT_NAME = C.CONSTRAINT_NAME 
									WHERE C.TABLE_NAME = UPPER('$fk[$k]')
									AND C.CONSTRAINT_TYPE = 'P'");
					$r_find_fk_key = oci_execute($find_fk_key);
					$row_fk_key = oci_fetch_array($find_fk_key);
					$fk_key[$k] = $row_fk_key[0];
				}
			}
			//-- prepare to keep data --//
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
                        <div class="panel-heading">
                            <?php echo "<i class=\"fa fa-pencil fa-fw\"></i>Insert Data Below";?>
							
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <form id="addForm" method="post" action="addSave.php" class="form-horizontal">
							<fieldset>
							<?php
								$script_string = '';
								for($i = 0; $i < $ncols; $i++) {
									$colname = oci_field_name($s, $i+1);
									$check_row = oci_fetch_array($check_table_detail);
									$data_type = $check_row[1];
									$data_length = $check_row[2];
									$nullable = $check_row[3];
									
									echo "<div class=\"form-group\">";
										echo "<label class=\"col-lg-3 control-label\">";
											echo "".htmlentities($colname, ENT_QUOTES)."";
										echo "</label>";
										echo "<div class=\"col-lg-5\">";
											if($Num_fk>0){
												$have_fk = 0;
												for($k = 0;$k<$Num_fk;$k++ ){
													if($colname == $fk_colName[$k]){
														$have_fk=1;
														echo "<select class=\"form-control\" name=addtext".$i.">";
														echo "<option value=\"\"> --Select Value --</option>";
														$fk_reference = oci_parse($c, "select * from $fk[$k] order by $fk_key[$k]");
														$r_fk_reference = oci_execute($fk_reference);
														if($tableName !='ANSWER'){
															while($row_reference = oci_fetch_array($fk_reference)) {
																echo "<option value=\"".$row_reference[0]."\">".$row_reference[0]." --------- ".$row_reference[1]."</option>";
															}
														}else{
															while($row_reference = oci_fetch_array($fk_reference)) {
																echo "<option value=\"".$row_reference[0]."\">".$row_reference[0]." --------- ".$row_reference[2]."</option>";
															}
														}
														echo "</select>";
													}
												}
												if($data_type=='DATE'){
													echo "<input type='date'  class=\"form-control\" name=addtext".$i.">";
												}else if($have_fk==0){
													echo "<input type='text' class=\"form-control\" name=addtext".$i.">";
												}
											}else{
												echo "<input type='text' class=\"form-control\" name=addtext".$i.">";
											}
										echo "</div>";
									echo " </div>";
									//Make Script
									$script_string .= "addtext".$i." :{";
									$script_string .= "validators: {";
									if($nullable=='N'){
										$script_string .= "notEmpty: { message: 'This field is required and can\'t be empty'}";
										if($data_type=='NUMBER'){
											$script_string .= ",greaterThan: { value: -1,inclusive: false,
																message: 'This value has to be greater than or equals to 0'}";
										}else if($data_type=='VARCHAR2'){
											$script_string .=",stringLength: {
												max: $data_length,
												message: 'This field must be less than $data_length characters long'
											}";
										}
									}else if($data_type=='NUMBER'){
										$script_string .= "greaterThan: {
											value: -1,
											inclusive: false,
											message: 'This value has to be greater than or equals to 0'
										}";
									}else if($data_type=='VARCHAR2'){
										$script_string .="stringLength: {
											max: $data_length,
											message: 'The username must be less than $data_length characters long'
										}";
									}
									$script_string .= "}";
									if($i < $ncols-1){
										$script_string .= "},";
									}else{
										$script_string .= "}";
									}
									//echo $script_string;
								}
								echo "<input type ='hidden' value='".$ncols."' name='n'>";
								echo "<input type ='hidden' value='".$tableName."' name='table'>";
							?>
								<div class="form-group">
									<div class="col-lg-9 col-lg-offset-3">
										<button type="submit" class="btn btn-primary">Submit</button>
									</div>
								</div>
								</fieldset>
							</form>
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
		
	<!--<script type="text/javascript" src="vendor/jquery/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="vendor/bootstrap/js/bootstrap.min.js"></script> -->
	<script type="text/javascript" src="dist/js/bootstrapValidator.js"></script>
	<script type="text/javascript">
	$(document).ready(function() {
		$('#addForm').bootstrapValidator({
		message: 'This value is not valid',
			feedbackIcons: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			fields: {
				<?php echo $script_string?>
			}
		});
	});
	</script>       
</body>

</html>
