<html>
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

		echo "<head>";
		echo "<title>{$row["building_address"]}</title>";
		echo "<style>";
		echo ".info {  position: relative;
		  padding: 100px 0px;
		  width: 100%;
		  color: white;
		  font-size: 20px;
		  background: #418040; /* Old browsers */
		  background: -moz-linear-gradient(top, #418040 0%, #376837 100%); /* FF3.6-15 */
		  background: -webkit-linear-gradient(top, #418040 0%,#376837 100%); /* Chrome10-25,Safari5.1-6 */
			background: linear-gradient(to bottom, #418040 0%,#376837 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */}";
	  echo ".imgViewer {width: 100%; height: 25em; background-color: #fbffdf; background-repeat:repeat; background-position: center;}";
		echo "td {padding: 1.5em;}";
		echo "p{text-indent:900px;}";
		echo ".name{text-indent:900px; font-family: \"New Courier\", Courier, monospace; font-size: 50px}";
		echo "ul{list-style-position: inside; text-indent:800px;}";
		echo "</style>";
		echo "</head>";
		echo "<body>";
		echo "<div class=\"imgViewer\" style=\"background-image:url(../helpers/location_images/{$row["image"]})\">";
		echo "</div>";
		echo "<div class=\"name\">";
		echo "{$row["building_address"]}";
		echo "</div>";
		echo "<div class=\"info\">";
		echo "<div>";
		echo "<p>General City Information</p>";
		echo "</div>";
		echo "<ul>";
		echo "<li><b>City: </b>{$row["city"]}</li>";
		echo "<li><b>Neighborhood: </b>{$row["neighborhood"]}</li>";
		echo "<li><b>Police District: </b>{$row["police_district"]}</li>";
		echo "</ul>";
		echo "<br>";
		echo "<p>Specific Property Information</p>";
		echo "<ul>";
		echo "<li> <b>Block: </b>{$row["block"]}</li>";
		echo "<li> <b>Lot: </b>{$row["lot"]}</li>";
		echo "<li> <b>Zip Code: </b>{$row["zip_code"]}</li>";
		echo "</ul>";
		echo "<br>";
		echo "<p>Current Use Information</p>";
		echo "<ul>";
		echo "<li><b>Owner: </b>{$row["owner"]}</li>";
		echo "<li><b>What It Is Being Used As: </b>{$row["use"]}</li>";
		echo "<li><b>Mailing Address: </b>{$row["mailing_address"]}</li>";
		echo "</ul>";
		echo "<br>";
		echo "<p>Other</p>";
		echo "<ul>";
		echo "<li><b>Council District: </b>{$row["council_district"]}</li>";
		echo "<li><b>Longitude: </b>{$row["longitude"]}</li>";
		echo "<li><b>Latitude: </b>{$row["latitude"]}</li>";
		echo "</ul>";
		echo "<div>";
		echo "<br>";
		echo "<p>Description:</p>";
		echo "<p>This section includes a general description about this specific lot and </p>";
		echo "<p>will include details provided by the creator of this location's page. </p>";
		echo "</div>";
		echo "</div>";
		echo "</body>";
	?>
</html>
