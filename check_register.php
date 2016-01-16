<?php
ob_start();
$c = oci_connect("TEST", "New25377", "localhost/XE");


// Define $myusername and $mypassword 
$myusername=$_POST['myusername']; 
$mypassword=$_POST['mypassword']; 
$encrypted_mypassword=md5($mypassword);
$myname=$_POST['myusername']; 
$myemail=$_POST['myemail']; 
$s = oci_parse($c, "select * from members where username='$myusername'");
$r = oci_execute($s);

$count = oci_fetch_array($s, OCI_ASSOC);

// If result matched $myusername and $mypassword, table row must be 1 row
if($count){
echo "Fail to register!";
echo "Your username can't use";
?>
<html>
<body>
<p><a href="register.php">Back</a></p>
</body>
</html>

<?php
}
else {
$s = oci_parse($c, "insert into members values( seq_mem_ID.nextval,'$myusername','$encrypted_mypassword','3','$myname','$myemail')");
$r = oci_execute($s);
echo "Register Successful";
header("location:index.php?reg=1");
?>
<html>
<body>
<p><a href="main_login.php">Login (Let Do It!)</a></p>
</body>
</html>

<?php
}
ob_end_flush();
?>