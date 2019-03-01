<?php
	include_once '../connect.php';
	$target_dir = "upload/";
	$file = $target_dir . basename($_FILES["pic"]["name"]);
	$target_file="../../".$file;
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
	    $check = getimagesize($_FILES["pic"]["tmp_name"]);
	    if($check !== false) {
	        //echo "File is an image - " . $check["mime"] . ".";
	        $uploadOk = 1;
	    } else {
	        //echo "File is not an image.";
	        $uploadOk = 0;
	    }
	}
	// Check if file already exists
	if (file_exists($target_file)) {
	    //echo "Sorry, file already exists.";
	    $uploadOk = 0;
	}
	// Check file size
	if ($_FILES["pic"]["size"] > 500000) {
	    //echo "Sorry, your file is too large.";
	    $uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	    //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	    $uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	    
	// if everything is ok, try to upload file
	} else {
	    if (move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file)) {
	        //echo "The file ". basename( $_FILES["pic"]["name"]). " has been uploaded.";
	    } else {
	        //echo "Sorry, there was an error uploading your file.";
	    }
	}
	$image=$file;
	$name=$_POST['name'];
	$category=$_POST['category'];
	$description=$_POST['description'];
	$latitude=$_POST['latitude'];
	$longitude=$_POST['longitude'];
	$getCatID="select cid from category where cname='$category'";
	$result=mysqli_query($con,$getCatID);
	$row=mysqli_fetch_array($result);
	$category=$row['cid'];
	$data="insert into places(name,description,cid,latitude,longitude,rating,image) values('$name','$description','$category','$latitude','$longitude','1','$image')";
	$result=mysqli_query($con,$data);
	header("Location: ../../places.php");
?>