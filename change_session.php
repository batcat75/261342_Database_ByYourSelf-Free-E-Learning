<?php
	session_start();
	$_SESSION['Table'] = $_GET['Table'];
	//echo$_SESSION['Table'];
	header("location:tables.php");
?>