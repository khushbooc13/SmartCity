<html>
<?php
include_once 'php/connect.php';
  $allcategories="select * from category";
  

?>
<head>
	<link rel="stylesheet" href="style.css" type="text/css">
  <script src="js/jquery-1.12.0.min.js"></script>
	<script>
	  $(function() 
	  {
    	$( "i" ).click(function() 
    	{
      		$( "i,span" ).toggleClass( "press", 1000 );
    	});
  	  });
      function changeBackground(v)
      {
        var bg=document.getElementById("bg");
      
      <?php
      $result=mysqli_query($con,$allcategories);
      while($row=mysqli_fetch_array($result))
      {
        $cname=$row['cname'];
        ?>
          if(v=='<?php echo $cname;?>')
          bg.style.backgroundImage = "url(img/<?php echo strtolower($cname);?>.jpg)";
        <?php
      }
      ?>
      }
      function reset()
      {
         var bg=document.getElementById("bg");
         bg.style.backgroundImage = "url(img/4.jpg)";
         bg.size='100%';
      }
      
  	  </script>
</head>
<body>
<div  class="like" Id="bg"></div>
<div class="header">
  <div class="logo">
  <a href="index.php"><img src="img/logo(ps1).png"></a>
</div>
    <div class ="navbar">
    <ul>
  <li><a class="nav" href="login.html">Login</a></li>
  <li><a class="nav" href="signup.html">Sign Up</a></li>
  <li><a class="nav" href="aboutus.html">About Us</a></li>
  </ul>
</div>
     </div>
     
  <div class="over">
    <i></i>
  <span class="liked">liked!</span>
  </div> 
  <div class="categories">
  <?php
  $result=mysqli_query($con,$allcategories);
    while($row=mysqli_fetch_array($result))
    {
      $cid=$row['cid'];
      $cname=$row['cname'];
      $r=mysqli_query($con,"select count(*) as total from places where cid='$cid'");
      $r=mysqli_fetch_array($r);
      ?>
      <span class="btngroup">
        <button class="btngroup--btn"><a href="places.php?cid=<?php echo $cid;?>" onmouseover="changeBackground('<?php echo $cname;?>')" onmouseout="reset()"><?php echo $cname;?></a></button>
        <button class="btngroup--btn"><?php echo $r['total'];?></button>
      </span>
      <?php
    }
  ?>
  
</div>

</body>
</html>
