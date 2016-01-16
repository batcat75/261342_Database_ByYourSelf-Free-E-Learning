<?php
	session_start();
	if(!isset($_SESSION['myusername'])){
		header("location:main_login.php");
	}
	$_SESSION['Table'] = $_GET['Table'];
	header("location:login_success.php?Page=1&Row_Per_Page=".$_GET['Row_Per_Page']."");
?>