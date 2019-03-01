<html>
<head>
	<script src="js/jquery-1.12.0.min.js"></script>
	<link rel="stylesheet" href="css/bootstrap.css" type="text/css">
  <link rel="stylesheet" href="css/font-awesome.css" type="text/css">
  <link rel="stylesheet" href="css/categories.css" type="text/css">
	<script src="js/bootstrap.js">
	</script>
	<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCFy36L72NkL8Q8QPxXnK9AWuf8byAwi-I">
</script>
<?php 
  session_start();
  include_once 'php/connect.php';
  if(isset($_SESSION['uid']))
    $uid=$_SESSION['uid'];
  else
  {
    ?>
    <script>
      window.alert("Not Logged In!");
    </script>
    <?php
  }
  if(!isset($_GET['id']))
    header("Location: places.php");
  $id=$_GET['id'];
  $getinfo="select * from category as c,places as p where c.cid=p.cid and p.id='$id'";
  $result=mysqli_query($con,$getinfo);
  $row=mysqli_fetch_array($result);

?>
<script>
function initialize() {
	var mark=new google.maps.LatLng(<?php echo $row['latitude']?>, <?php echo $row['longitude']?>);
  var mapProp = {
    center:mark,
    zoom:16	,
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  var icons="img/pins/";
  var map=new google.maps.Map(document.getElementById("googleMap"), mapProp);
  var marker = new google.maps.Marker({
  position: mark,
  map: map,
  icon: icons+'<?php echo $row['icon']?>'
});
  marker.setMap(map);
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
        <li class="dropdown">
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
        <li><a href="#">About Us</a></li>
        <li>
        <a href="#"> Contact Us</a>
      </li>
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
            <li><a href="#">Log In</a></li>
            <li><a href="#">Sign Up</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Log Out</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<?php
$result=mysqli_query($con,$getinfo);
  $row=mysqli_fetch_array($result);
?>
<div id="googleMap" style="width:100%;height:600px;"></div>
<div class="container">
<div class="row"></div>
  <div class="row">
    <div class="col-md-10 col-xs-12 col-sm-12">
   		 <div class="showinfo-title"><?php echo $row['name']?>
       </div>
    </div>
  </div>
    <div class="row">
      <div class="col-md-10 col-xs-12 col-sm-12">
        <div class="row showinfo-content">
          
          <div class="col-md-8 showinfo-desc">
            <?php echo $row['description']?>
            
            <h3>Category: <i><?php echo $row['cname']?></i></h3>
            <div class="row">
            <div class="col-md-6 showinfo-rating">
                <h3>User Ratings: </h3>
                <fieldset>
            <?php
            $getreviews="select round(avg(indivrating)) as rating,count(indivrating)as views from reviews where id='$id'";
            $r=mysqli_query($con,$getreviews);
            $r=mysqli_fetch_array($r);
            $rating=$r['rating'];
            
            ?>
          <span class="star-cb-group">
            <input disabled type="radio" id="rating-5<?php echo $id?>" name="rating<?php echo $id?>" value="5" <?php if($rating==5){echo "checked";}?>/><label for="rating-5<?php echo $id?>">5</label>
            <input disabled type="radio" id="rating-4<?php echo $id?>" name="rating<?php echo $id?>" value="4" <?php if($rating==4){echo "checked";}?> /><label for="rating-4<?php echo $id?>">4</label>
            <input disabled type="radio" id="rating-3<?php echo $id?>" name="rating<?php echo $id?>" value="3" <?php if($rating==3){echo "checked";}?>/><label for="rating-3<?php echo $id?>">3</label>
            <input disabled type="radio" id="rating-2<?php echo $id?>" name="rating<?php echo $id?>" value="2" <?php if($rating==2){echo "checked";}?>/><label for="rating-2<?php echo $id?>">2</label>
            <input disabled type="radio" id="rating-1<?php echo $id?>" name="rating<?php echo $id?>" value="1" <?php if($rating==1){echo "checked";}?>/><label for="rating-1<?php echo $id?>">1</label>
            <input disabled type="radio" id="rating-0<?php echo $id?>" name="rating<?php echo $id?>" value="0" class="star-cb-clear" <?php if($rating==0){echo "checked";}?>/><label for="rating-0<?php echo $id?>">0</label>
          </span>
        </fieldset>
            </div>
            <div class="col-md-6 showinfo-views">
            <h3>Views:</h3>
            <div class="view-count"><i class="fa fa-eye"></i> <?php echo $r['views']?></div>
            </div>
            </div>
          </div>
          <div class="col-md-4">
          <div class="image">
          <img src="<?php echo $row['image'];?>">
          </div>
          </div>
        </div>
        <div class="showinfo-reviews">
        <h2>User Reviews:</h2>
        

        <?php
        $getreviews="select * from reviews where id='$id'";
        $result=mysqli_query($con,$getreviews);
        while($row=mysqli_fetch_array($result))
        {
          $userid=$row['uid'];
          $getusername="select username from users where uid='$userid'";
          $ans=mysqli_query($con,$getusername);
          $r=mysqli_fetch_array($ans);
          $rid=$row['rid'];
          ?>
          <div class="reviews">
          <div class="row">
            <div class="col-md-6 reviews-username">
              <h4><?php echo $r['username'];?></h4>
            </div>
            <div class="col-md-6 ">
            <div class="reviews-ratings"> 
              <fieldset>
                 <?php
            $rating=$row['indivrating'];
            
            ?>
          <span class="star-cb-group">
            <input disabled type="radio" id="rating-5<?php echo $id?><?php echo $rid?>" name="rating<?php echo $id?><?php echo $rid?>" value="5" <?php if($rating==5){echo "checked";}?>/><label for="rating-5<?php echo $id?><?php echo $rid?>">5</label>
            <input disabled type="radio" id="rating-4<?php echo $id?><?php echo $rid?>" name="rating<?php echo $id?><?php echo $rid?>" value="4" <?php if($rating==4){echo "checked";}?> /><label for="rating-4<?php echo $id?><?php echo $rid?>">4</label>
            <input disabled type="radio" id="rating-3<?php echo $id?><?php echo $rid?>" name="rating<?php echo $id?><?php echo $rid?>" value="3" <?php if($rating==3){echo "checked";}?>/><label for="rating-3<?php echo $id?><?php echo $rid?>">3</label>
            <input disabled type="radio" id="rating-2<?php echo $id?><?php echo $rid?>" name="rating<?php echo $id?><?php echo $rid?>" value="2" <?php if($rating==2){echo "checked";}?>/><label for="rating-2<?php echo $id?><?php echo $rid?>">2</label>
            <input disabled type="radio" id="rating-1<?php echo $id?><?php echo $rid?>" name="rating<?php echo $id?><?php echo $rid?>" value="1" <?php if($rating==1){echo "checked";}?>/><label for="rating-1<?php echo $id?><?php echo $rid?>">1</label>
            <input disabled type="radio" id="rating-0<?php echo $id?><?php echo $rid?>" name="rating<?php echo $id?><?php echo $rid?>" value="0" class="star-cb-clear" <?php if($rating==0){echo "checked";}?>/><label for="rating-0<?php echo $id?><?php echo $rid?>">0</label>
          </span>
        </fieldset>
              </div>
            </div>
          </div>
          <div class="reviews-comment">
            <i><?php echo $row['review'];?></i>
          </div>
          </div>
          <hr>
          <?php
        }

        ?>
        
          
          <div class="reviews">
          <form action="php/scripts/submitReview.php" method="post">
            <div class="row">
              <div class="col-md-6 reviews-username">
                <h3>Write A Review</h3>
              </div>
              <div class="col-md-6 ">
                <div class="row">
                  <label class="col-md-4 control-label showinfo-label">Give a Rating :</label>
                    <div class="reviews-ratings col-md-8"> 
                      <fieldset>
                          <span class="star-cb-group">
                            <input type="radio" id="rating-5" name="rating" value="5" /><label for="rating-5">5</label>
                            <input type="radio" id="rating-4" name="rating" value="4" /><label for="rating-4">4</label>
                            <input type="radio" id="rating-3" name="rating" value="3" /><label for="rating-3">3</label>
                            <input type="radio" id="rating-2" name="rating" value="2" /><label for="rating-2">2</label>
                            <input type="radio" id="rating-1" name="rating" value="1" /><label for="rating-1">1</label>
                            <input type="radio" id="rating-0" name="rating" value="0" class="star-cb-clear" checked="checked" /><label for="rating-0">0</label>
                          </span>
                        </fieldset>
                    </div>
                </div>
              </div>
              <div class="reviews-comment col-md-10">
                <textarea name="review" class="form-control" placeholder="Write about your experience in short.."></textarea>
              </div>
              <div class="row">
                <button class="btn btn-success">Submit Review</button>
              </div>
              <input type="hidden" name="id" value="<?php echo $_GET['id']?>">
              <input type="hidden" name="uid" value="<?php echo $uid?>">
            </div>
            </form>
          </div>
          
        </div>
      </div>
    
    </div>
  </div>
</body>
</html>