<?php
require('php/connect.php');

{
		$query="SELECT * FROM users where username='".$_POST['username']."'";
		$result=mysqli_query($con, $query);
		if(isset($_POST["password"]) && isset($_POST["repassword"]) && $_POST['password']==$_POST['repassword'])
		{
			if(mysqli_num_rows($result)==0)
			{
				$query="INSERT INTO users(username,email,password) VALUES('".$_POST['username']."','".$_POST['email']."','".$_POST['password']."')";
				$result=mysqli_query($con, $query);
				
				header("Location: login.html");
			}
			else
			{
			?>
				<font color="red">
				<h1> "User is Already registerd" <h1 />
				</font>
		<?php
			}
		}
}
?>