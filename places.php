<html>
<head>
	<script src="js/jquery-1.12.0.min.js"></script>
	<link rel="stylesheet" href="css/bootstrap.css" type="text/css">
  <link rel="stylesheet" href="css/font-awesome.css" type="text/css">
  <link rel="stylesheet" href="css/categories.css" type="text/css">
	<script src="js/bootstrap.js">
	</script>
	<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCFy36L72NkL8Q8QPxXnK9AWuf8byAwi-I" >
</script>
<?php
include_once 'php/connect.php';
$param="";
if(isset($_GET['cid']))
  $param=" cid='".$_GET['cid']."'";
else
  $param=" 1=1";
if(isset($_GET['s']))
{
  $q=$_GET['s'];
  $param=$param." and name like '%$q%'";
}
$allplaces="select * from places where".$param;
$result=mysqli_query($con,$allplaces);
$i=0;
while($row=mysqli_fetch_array($result))
{
  $id[$i]=$row['id'];
  $latitude[$i]=$row['latitude'];
  $longitude[$i]=$row['longitude'];
}
?>
<script>
function initialize() {
	var mark=new google.maps.LatLng(19.0930, 72.8258);
  var mapProp = {
    center:mark,
    zoom:11	,
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  var icons="img/pins/";
  var map=new google.maps.Map(document.getElementById("googleMap"), mapProp);
  
  <?php
  $i=0;
  $result=mysqli_query($con,$allplaces);
    while($row=mysqli_fetch_array($result))
    {
      $cid=$row['cid'];
      $query="Select icon from category where cid='$cid'";

      $ans=mysqli_query($con,$query);
      $ic=mysqli_fetch_array($ans);

      ?>
          var pin<?php echo $i?> =new google.maps.LatLng(<?php echo $row['latitude'];?>, <?php echo $row['longitude'];?>);
          var marker<?php echo $i?> = new google.maps.Marker({
          position: pin<?php echo $i?>,
          map: map,
          icon: icons+'<?php echo $ic['icon'];?>'
        });
          marker<?php echo $i?>.setMap(map);
          
          var contentStr = '<div id="content">'+
      '<div id="siteNotice">'+
      '</div>'+
      '<h1 id="firstHeading" class="firstHeading"><?php echo $row['name']?></h1>'+
      '<div id="bodyContent">'+
      '<p></p>'+
      '</div>'+
      '</div>';
          var infowindow<?php echo $i?> = new google.maps.InfoWindow({
            content:contentStr
          });

          google.maps.event.addListener(marker<?php echo $i?>, 'click', function() {
          infowindow<?php echo $i?>.open(map,marker<?php echo $i?>);
          });

      <?php
      $i++;
    }
    ?>
  
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
</head>
<body>
	<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Home</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="dropdown active">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Categories<span class="caret"></span></a>
          <ul class="dropdown-menu">
          <?php
              $categories="select * from category";
              $result=mysqli_query($con,$categories);
              while($row=mysqli_fetch_array($result))
              {
                ?>
                <li><a href="places.php?cid=<?php echo $row['cid'];?>"><?php echo $row['cname'];?></a></li>
                <?php
              }
            ?>
          </ul>
        </li>
        <li><a href="aboutus.html">About Us</a></li>
      </ul>
      <form class="navbar-form navbar-right" role="search" action="places.php">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search" name="s">
        </div>
        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Account<span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="login.html">Log In</a></li>
            <li><a href="signup.html">Sign Up</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="logout.php">Log Out</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<div id="googleMap" style="width:100%;height:600px;"></div>
<div class="container">
<div class="row"></div>
  <div class="row">
  <?php
  $result=mysqli_query($con,$allplaces);
  while($row=mysqli_fetch_array($result))
  {
    $id=$row['id'];
    $getreviews="select round(avg(indivrating)) as rating,count(indivrating)as views from reviews where id='$id'";
    $r=mysqli_query($con,$getreviews);
    $r=mysqli_fetch_array($r);

    ?>
    <div class="col-md-3 col-xs-12 col-sm-6">
   		 <a href="showinfo.php?id=<?php echo $id;?>" class="info"><div class="grid-item">
          <img class="grid-image img-thumbnail" src="<?php echo $row['image'];?>">
          
            <fieldset>
            <?php
            $rating=$r['rating'];
            
            
            ?>
    			<span class="star-cb-group">
			      <input disabled type="radio" id="rating-5<?php echo $id?>" name="rating<?php echo $id?>" value="5" <?php if($rating==5){echo "checked";}?>/><label for="rating-5<?php echo $id?>">5</label>
			      <input disabled type="radio" id="rating-4<?php echo $id?>" name="rating<?php echo $id?>" value="4" <?php if($rating==4){echo "checked";}?> /><label for="rating-4<?php echo $id?>">4</label>
			      <input disabled type="radio" id="rating-3<?php echo $id?>" name="rating<?php echo $id?>" value="3" <?php if($rating==3){echo "checked";}?>/><label for="rating-3<?php echo $id?>">3</label>
			      <input disabled type="radio" id="rating-2<?php echo $id?>" name="rating<?php echo $id?>" value="2" <?php if($rating==2){echo "checked";}?>/><label for="rating-2<?php echo $id?>">2</label>
			      <input disabled type="radio" id="rating-1<?php echo $id?>" name="rating<?php echo $id?>" value="1" <?php if($rating==1){echo "checked";}?>/><label for="rating-1<?php echo $id?>">1</label>
			      <input disabled type="radio" id="rating-0<?php echo $id?>" name="rating<?php echo $id?>" value="0" class="star-cb-clear" <?php if($rating==0){}?>/><label for="rating-0<?php echo $id?>">0</label>
			    </span>
  			</fieldset>
  			<div class="views">
  				<i class="fa fa-eye"></i> <?php echo $r['views']?>
  			</div>
        <div class="title">
          <?php echo $row['name'];?>
        </div>
  			<div class="description">
  			<?php echo $row['description']?>
  			</div>
          </div></a>
    </div>
    <?php
  }
    ?>
    
    
    <div class="col-md-3">
    </div>
    </div>
  </div>
</body>
</html>