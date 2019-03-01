<?php
	include_once '../connect.php';
	$id=$_POST['id'];
	$review=$_POST['review'];
	$rating=$_POST['rating'];
	$uid=$_POST['uid'];
	$data="insert into reviews(id,uid,review,indivrating) values('$id','$uid','$review','$rating')";
	$result=mysqli_query($con,$data);
	header("Location: ../../showinfo.php?id=".$id);
?>