<?php
include_once 'php/connect.php';



?>
<html>
<head>
	<script src="js/jquery-1.12.0.min.js"></script>
	<link rel="stylesheet" href="css/bootstrap.css" type="text/css">
  <link rel="stylesheet" href="css/font-awesome.css" type="text/css">
  <link rel="stylesheet" href="css/categories.css" type="text/css">
	<script src="js/bootstrap.js"></script>
  <script src="js/validator.js"></script>
	<script src="http://maps.googleapis.com/maps/api/js?libraries=places">
</script>

<script>
var map;
var mark;
var marker;

function initialize() {
	mark=new google.maps.LatLng(19.0930, 72.8258);
  var mapProp = {
    center:mark,
    zoom:11	,
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  
  map=new google.maps.Map(document.getElementById("googleMap"), mapProp);
  google.maps.event.addListener(map, 'click', function(event) {
  placeMarker(event.latLng);
  });
  marker=new google.maps.Marker({
      position: mark,
      map: map,
    });;
  
  var input = document.getElementById('inputSearch');
  var searchBox = new google.maps.places.SearchBox(input);
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  // Bias the SearchBox results towards current map's viewport.
  map.addListener('bounds_changed', function() {
    searchBox.setBounds(map.getBounds());
  });

  searchBox.addListener('places_changed', function() {
    var places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }

    var bounds = new google.maps.LatLngBounds();

    places.forEach(function(place) {
      if (place.geometry.viewport) {
        // Only geocodes have viewport.
        bounds.union(place.geometry.viewport);
      } else {
        bounds.extend(place.geometry.location);
      }
    });
    map.fitBounds(bounds);
  });

}
google.maps.event.addDomListener(window, 'load', initialize);

function placeMarker(location)
{
  var lat=document.getElementById("inputLat");
  var longi=document.getElementById("inputLong");
  marker.setPosition(location);
  lat.value=location.lat();
  longi.value=location.lng();
}
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
      <a class="navbar-brand" href="index.html">Home</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Categories<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Restaurants</a></li>
            <li><a href="#">Shopping</a></li>
            <li><a href="#">Night Life</a></li>
            <li><a href="#">Historical Places</a></li>
            <li><a href="#">Bus Routes</a></li>
            <li><a href="#">Things To Do</a></li>
          </ul>
        </li>
        <li class="active"><a href="#">About Us<span class="sr-only">(current)</span></a></li>
        <li>
        <a href="#"> Contact Us</a>
      </li>
      </ul>
      <form class="navbar-form navbar-right" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
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

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="addplace-title">Add Place</div>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="form"> 
    <form class="form-horizontal" method="post" action="php/scripts/insertPlace.php" data-toggle="validator" role="form" enctype="multipart/form-data">
      <div class="form-group has-feedback">
         <label for="inputName" class="col-sm-2 control-label">Name :</label>
           <div class="col-sm-10">
             <input type="text" class="form-control" id="inputName" placeholder="Name Of the Place" name="name" required>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
           </div>
          
      </div>
      <div class="form-group">
         <label for="inputCategory" class="col-sm-2 control-label">Category :</label>
           <div class="col-sm-10">
             <select class="form-control" name="category" id="inputCategory" >
             <?php
             $categories="select * from category";
              $result=mysqli_query($con,$categories);
              while($row=mysqli_fetch_array($result))
              {
                ?>
                  <option><?php echo $row['cname'];?></option>
                <?php
              }
             
             ?>
             </select>
             
           </div>
      </div>
      <div class="form-group has-feedback">
         <label for="inputDesc" class="col-sm-2 control-label">Description :</label>
           <div class="col-sm-10">
             <textarea class="form-control col-sm-10" id="inputDesc" placeholder="Description" name="description" rows=3 required></textarea>
             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
           </div>
      </div>
      <div class="form-group">
         <label for="inputImg" class="col-sm-2 control-label">Image :</label>
           <div class="col-sm-10">
             <input type="file" class="form-control" id="inputImg" placeholder="Image" name="pic">
           </div>
      </div>
      <div class="form-group">
         <label for="inputLat" class="col-sm-2 control-label">Latitude :</label>
           <div class="col-sm-4 has-feedback">
             <input type="text" class="form-control" id="inputLat" placeholder="Latitude" name="latitude" required>
             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
           </div>
           <label for="inputLong" class="col-sm-2 control-label">Longitude :</label>
           <div class="col-sm-4 has-feedback">
             <input type="text" class="form-control" id="inputLong" placeholder="Longitude" name="longitude" required>
             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
           </div>
            
      </div>
      
      <div class="form-group">
      <div class="col-md-10 col-md-offset-2">
           <div id="googleMap" class="form-control" style="height:500px"></div>
           </div>
           <input type="text" class="searchplaces" id="inputSearch" placeholder="Search Places" name="searchplaces" >
      </div>
      <div class="form-group">
        <button class="btn btn-success col-md-4 col-md-offset-5">Submit</button>
      </div>
    </form>
  </div>
</div>
</body>
</html>