<?php
	ob_start();
	$c = oci_connect("TEST", "New25377", "localhost/XE");

	// Define $myusername and $mypassword 
	$myusername=$_POST['myusername']; 
	$mypassword=$_POST['mypassword']; 
	$encrypted_mypassword=md5($mypassword);

	$s = oci_parse($c, "select * from members where username='$myusername' and password='$encrypted_mypassword'");
	$r = oci_execute($s);

	$count = oci_fetch_array($s, OCI_ASSOC);
	
	// If result matched $myusername and $mypassword, table row must be 1 row
	if($count){
		$r = oci_execute($s);
		$objResult = oci_fetch_array($s);
		session_start();
		// Register $myusername, $mypassword and redirect to file "learn.php"
		$_SESSION['myusername'] = $myusername;
		$_SESSION['user_id'] = $objResult["ID"];
		$_SESSION['user_type'] = $objResult["TYPE"];
		$_SESSION['check_login'] = 1;
		header("location:learn.php");
	}else {
		$_SESSION['check_login'] = 2;
		header("location:main_login.php");
?>
<html>
	<body>
		<p><a href="main_login.php">Login</a></p>
	</body>
</html>

<?php
	}
	ob_end_flush();
?>