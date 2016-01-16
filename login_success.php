<?php
	session_start();
	if(!isset($_SESSION['myusername'])){
		header("location:main_login.php");
	}
	
	$c = oci_connect("TEST", "New25377", "localhost/XE");
	$s = oci_parse($c, "select table_name from user_tables order by table_name");
	$r = oci_execute($s);
?>

<html>
	<head>
		<link href="table.css" rel="stylesheet">
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css"/>
		<script type="text/javascript" src="vendor/jquery/jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="vendor/bootstrap/js/bootstrap.min.js"></script>
	</head>
	<body>   
	<?php 
		echo "<div class =\"header\">";
		echo "Username :  ";
		echo $_SESSION['myusername'];
		echo "&nbsp&nbsp&nbsp <a href=\"logout.php\" class=\"btn btn-primary btn-sm\" role=\"button\">Logout</a>";
		echo "</div>";
		$ncols = oci_num_fields($s);
		
		if(isset($_GET["Row_Per_Page"])){
			$Per_Page = $_GET["Row_Per_Page"];   // Per Page
		}else{
			$Per_Page = 10;
		}
		
		echo "<div class=\"manu\">";
		echo "<form action=\"change_session.php\" method=\"get\">";
		echo "Table : &nbsp";
		echo "<select name=\"Table\" >";
		while (($row = oci_fetch_array($s, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
			foreach ($row as $item) {
				echo"<option ";
				if(isset($_SESSION['Table'])){
					if($_SESSION['Table']==$item){
						echo "&nbsp selected &nbsp";
					}
				}
				echo "value=\"$item\">$item</option>";
			}
		}
		echo "</select>";
		// Row Per Page Selection //////////////////////////////////////////////
	?>
		Rows : 
		<select name="Row_Per_Page" >
		<option <?php if($Per_Page==5){echo 'selected';}?> value="5">5</option>
		<option <?php if($Per_Page==10){echo 'selected';}?> value="10">10</option>
		<option <?php if($Per_Page==20){echo 'selected';}?> value="20">20</option>
		<option <?php if($Per_Page==50){echo 'selected';}?> value="50">50</option>
		<option <?php if($Per_Page==100){echo 'selected';}?> value="100">100</option>
		<option <?php if($Per_Page==200){echo 'selected';}?> value="100">200</option>
		</select>
		<input type ='hidden' value="<?php echo $tableName;?>" name='tableName'>
		<input type ='hidden' value='1' name='Page'>
	<?php
		echo "<input type=\"submit\" name=\"submit\" value=\"Go\" />";
		echo "</form>";
		echo "</div>";
		echo "<div class=\"container-fluid\">";
		/////////////////////////////////////////////////////////////////////////
		if(!isset($_SESSION['Table'])){
			echo "<br><p class=\"text-center\">WELCOME <br> Choose Your Data Table.</p>";
		}else{
			//echo $_SESSION['Table'];
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
			//SET LIST PAGING ////////////////////////////////////////////////
			$s = oci_parse($c, "select * from $tableName order by $key1");
			$r = oci_execute($s);
			$Num_Rows = oci_fetch_all($s, $Result);
			$pageCount = 0;
			
			$Page = $_GET["Page"];
			if(!$_GET["Page"])
			{
				$Page=1;
			}
	
			$Prev_Page = $Page-1;
			$Next_Page = $Page+1;
	
			$Page_Start = (($Per_Page*$Page)-$Per_Page);
			if($Num_Rows<=$Per_Page)
			{
				$Num_Pages =1;
			}
			else if(($Num_Rows % $Per_Page)==0)
			{
				$Num_Pages =($Num_Rows/$Per_Page) ;
			}
			else
			{
				$Num_Pages =($Num_Rows/$Per_Page)+1;
				$Num_Pages = (int)$Num_Pages;
			}
			$Page_End = $Per_Page * $Page;
			IF ($Page_End > $Num_Rows)
			{
				$Page_End = $Num_Rows;
			}
			
			// ADD Row
			echo "<div class=\"add_button\"><a href=addForm.php?tableName=".$tableName."&Page=".$Page."&Row_Per_Page=".$Per_Page.">Add Row</a>";
			echo "&nbsp;&nbsp;&nbsp;<input type=\"search\" id=\"search\" placeholder=\"Type to search\"></div>";
			
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
			
			echo "<div class=\"datagrid\">";
			echo "<table id=\"table\" ><thead><tr>";
			for ($i = 1; $i <= $ncols; ++$i) {
				$colname = oci_field_name($s, $i);
				echo "  <th>".htmlentities($colname, ENT_QUOTES)."</th>";
			}
			echo "  <th><b>edit</b></th>";
			echo "  <th><b>delete</b></th>";
			echo "</tr></thead>";
			
			echo "<tbody>";
			while($row = oci_fetch_array($s)) {
				if($pageCount>=$Page_Start&&$pageCount<$Page_End){
					echo "<tr class=\"search\">";
					for($i = 0; $i < $ncols; $i++) {
						echo "<td>" .$row[$i]. "</td>";
					}
					if($tableName=='PRE_COURSE'){
						echo "  <td><a href=editRecordForm.php?value_key1=".$row[0]."&value_key2=".$row[2]."&table=".$tableName."&Page=".$Page."&Row_Per_Page=".$Per_Page.">edit</td>";
						echo "<td><a href=\"deleteRecord.php?value_key1=".$row[0]."&value_key2=".$row[2]."&table=".$tableName."\"onclick=
							\"return confirm('Are you sure, you want to delete?')\">Delete</a></td>";
					}else if($Num_key==1){
						echo "  <td><a href=editRecordForm.php?value_key1=".$row[0]."&table=".$tableName."&Page=".$Page."&Row_Per_Page=".$Per_Page.">edit</td>";
						echo "<td><a href=\"deleteRecord.php?value_key1=".$row[0]."&table=".$tableName."\"onclick=
							\"return confirm('Are you sure, you want to delete?')\">Delete</a></td>";
					}else{
						echo "  <td><a href=editRecordForm.php?value_key1=".$row[0]."&value_key2=".$row[1]."&table=".$tableName."&Page=".$Page."&Row_Per_Page=".$Per_Page.">edit</td>";
						echo "<td><a href=\"deleteRecord.php?value_key1=".$row[0]."&value_key2=".$row[1]."&table=".$tableName."\"onclick=
							\"return confirm('Are you sure, you want to delete?')\">Delete</a></td>";
					}
					echo "</tr>";
				}
				$pageCount++;
			}
			echo"</tbody>";
			
			$ncols = $ncols+2;
			// LIST PAGING
			echo "<tfoot><tr><td colspan=".$ncols."><div id=\"paging\"><ul>";
			echo "Total ".$Num_Rows." Record : ".$Num_Pages." Page :";
			if($Prev_Page)
			{
				echo " <li><a href='$_SERVER[SCRIPT_NAME]?tableName=".$tableName."&Page=$Prev_Page&Row_Per_Page=".$Per_Page."'><< Back</a></li> ";
			}
	
			for($i=1; $i<=$Num_Pages; $i++){
				if($i != $Page)
				{
					echo "<li><a href='$_SERVER[SCRIPT_NAME]?tableName=".$tableName."&Page=$i&Row_Per_Page=".$Per_Page."'>$i</a></li> ";
				}
				else
				{
					echo "<li><lu><b> $i </b></lu></li>";
				}
			}
			if($Page!=$Num_Pages)
			{
				echo " <li><a href ='$_SERVER[SCRIPT_NAME]?tableName=".$tableName."&Page=$Next_Page&Row_Per_Page=".$Per_Page."'>Next>></a></li> ";
			}
			echo "</ul></div></tr></tfoot>";
			echo "</table>";
			echo "</div>";
			echo "</div>";
		}
	?>
	   <script type="text/javascript" >   
			var $rows = $('#table tr.search');
			$('#search').keyup(function() {
				var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
    
				$rows.show().filter(function() {
					var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
					return !~text.indexOf(val);
				}).hide();
			});  
		</script>
	</body>
</html>