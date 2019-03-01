<?php
	include_once 'php/connect.php';
	$username=$_POST['username'];
	$password=$_POST['password'];

	$login="select * from users where username='$username' and password='$password'";

	session_start();
	$result=mysqli_query($con,$login);
	$row=mysqli_fetch_array($result);
	$dbuser=$row['username'];
	$dbpass=$row['password'];
	if($username==$dbuser && $password==$dbpass)
	{
		$_SESSION['uid']=$row['uid'];
		header("Location: index.php");
	}
	else
	{
		header("Location: login.php");
	}
?>