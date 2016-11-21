<?php
	include "../helpers/conn.php";
	//$servername = "wwydh-mysql.cqqq2sesxkkq.us-east-1.rds.amazonaws.com";
	//$username = "wwydh_a_team";
	//$password = "nzqbzNU3drDhVsgHsP4f";

	//$conn = new mysqli($servername, $username, $password, "wwydh");
	$theQuery = "SELECT * FROM locations where `id`='{$_GET["id"]}'";
	$result = $conn->query($theQuery);
	$rowcount=mysqli_num_rows($result);
	$row = @mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html>

	<head>
		<link href="styles.css" type="text/css" rel="stylesheet" />
		<title><?php echo $row["building_address"] ?></title>
	</head>

	<body>
		<div class="imgViewer" style="background-image: url(../helpers/location_images/<?php echo $row["image"] ?>)";></div>
   <div class="name"><?php echo ($row["building_address"]) ?></div>
   <div class="info">
	  <div>
			   <p>General City Information</p>
	  </div>
	  <ul>
			  <li><b>City: </b><?php echo $row["city"] ?></li>
		  <li><b>Neighborhood: </b><?php echo $row["neighborhood"] ?></li>
		  <li><b>Police District: </b><?php echo $row["police_district"] ?></li>
	  </ul>
	  <br>
			<p>Specific Property Information</p>
		<ul>
		  <li> <b>Block: </b><?php echo $row["block"] ?></li>
		  <li> <b>Lot: </b><?php echo $row["lot"] ?></li>
		  <li> <b>Zip Code: </b><?php echo $row["zip_code"] ?></li>
		</ul>
		<br>
		<p>Current Use Information</p>
		<ul>
		  <li><b>Owner: </b><?php echo $row["owner"] ?></li>
		  <li><b>What It Is Being Used As: </b><?php echo $row["use"] ?></li>
		  <li><b>Mailing Address: </b> <?php echo $row["mailing_address"] ?></li>
		</ul>
		<br>
		<p>Other</p>
		<ul>
		  <li><b>Council District: </b><?php echo $row["council_district"] ?></li>
		  <li><b>Longitude: </b><?php echo $row["longitude"] ?></li>
		  <li><b>Latitude: </b><?php echo $row["latitude"] ?></li>
		</ul>
		<div>
		  <br>
		  <p>Description:</p>
		  <p>This section includes a general description about this specific lot and </p>
		  <p>will include details provided by the creator of this location's page. </p>
		</div>
	  </div>
<body>
</html>
