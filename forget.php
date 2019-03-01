<?php
	include_once 'php/connect.php';
	$username=$_POST['username'];
	$password=$_POST['password'];
	$newpass=$_POST['repassword'];

	$forget="update users SET password='".$newpass ."' where username='".$username."'";
	echo $forget;
	mysqli_query($con,$forget);
	header("Location:login.html");

?>