<?php
	session_start();
	if(!isset($_SESSION['myusername'])){
		header("location:main_login.php");
	}
?>
<html>
	<head>
		<link href="table.css" rel="stylesheet">
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
	</head>
	<body>
	<?php
		echo "<div class =\"header\">";
		echo "Username :  ";
		echo $_SESSION['myusername'];
		echo "&nbsp&nbsp&nbsp <a href=\"logout.php\">Logout</a>";
		echo "</div>";
	
		$c = oci_connect("TEST", "New25377", "localhost/XE");
		$s = oci_parse($c, "select * from ".$_GET["table"]."");
		$r = oci_execute($s);

		$successful = 0;
		$string = oci_field_name($s, 1);
		$string2 = oci_field_name($s, 2);
		if(isset($_GET['value_key2'])){
			$value_key2 = $_GET['value_key2'];
		}else{
			$value_key2 = 'NO_DATA';
		}
		if($value_key2 == 'NO_DATA'){
			$s = oci_parse($c, "delete  from ".$_GET["table"]." where $string = ".$_GET["value_key1"]."");
		}else{
			$s = oci_parse($c, "delete  from ".$_GET["table"]." 
								where $string = ".$_GET["value_key1"]."
								and $string2 = ".$_GET["value_key2"]."");
		}
		$r = oci_execute($s);
		if($s){
			echo "Record Deleted.";
			$successful = 1;
			header( "refresh:5;url=login_success.php?tableName=".$_GET["table"]."&Page=1" );
		}else{
			echo "Error Delete.";
		}
		echo "<br>";
		echo "  <td><a href=login_success.php?tableName=".$_GET["table"]."&Page = 1>back to ".$_GET["table"]."</a></td>\n";
		if($successful == 1){
			echo"<br><td>You will be back to ".$_GET["table"]." in <span id=\"counter\">5</span> second(s).</td>";
		}
	?>
	</body>
</html>






