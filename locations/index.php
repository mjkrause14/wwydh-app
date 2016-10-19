<?php

// test

	session_start();

	include "../helpers/paginate.php";
	include "../helpers/conn.php";

	$theQuery = "";
	$result = null;

	// count all records for pagination
	$q = $conn->prepare("SELECT COUNT(l.id) as total FROM locations l");
	$q->execute();

	$total = $q->get_result()->fetch_array(MYSQLI_ASSOC)["total"];
	$offset = $itemCount * ($page - 1);

	// BACKEND:20 change locations search code to prepared statements to prevent SQL injection
	if (isset($_GET["isSearch"])) {
		$theQuery = "SELECT * FROM `locations` WHERE `building_address` LIKE '%{$_GET["sAddress"]}%' AND `building_address` LIKE '%{$_GET["sAddress"]}%' AND `block` LIKE '%{$_GET["sBlock"]}%' AND `lot` LIKE '%{$_GET["sLot"]}%' AND `zip_code` LIKE '%{$_GET["sZip"]}%' AND `city` LIKE '%{$_GET["sCity"]}%' AND `neighborhood` LIKE '%{$_GET["sNeighborhood"]}%' AND `police_district` LIKE '%{$_GET["sPoliceDistrict"]}%' AND `council_district` LIKE '%{$_GET["sCouncilDistrict"]}%' AND `longitude` LIKE '%{$_GET["sLongitude"]}%' AND `latitude` LIKE '%{$_GET["sLatitude"]}%' AND `owner` LIKE '%{$_GET["sOwner"]}%' AND `use` LIKE '%{$_GET["sUse"]}%' AND `mailing_address` LIKE '%{$_GET["sMailingAddr"]}%'";
	} else {
		$q = $conn->prepare("SELECT l.*, COUNT(DISTINCT i.id) AS ideas, GROUP_CONCAT(DISTINCT f.feature SEPARATOR '[-]') AS features FROM locations l LEFT JOIN ideas i ON i.location_id = l.id LEFT JOIN location_features f ON f.location_id = l.id GROUP BY l.id ORDER BY ideas DESC LIMIT $itemCount OFFSET $offset");
	}

	$q->execute();
	$data = $q->get_result();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>All Locations</title>
		<link href="../helpers/header_footer.css" type="text/css" rel="stylesheet" />
		<link href="../helpers/splash.css" type="text/css" rel="stylesheet" />
		<link href="styles.css" type="text/css" rel="stylesheet" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

	</head>
	<body>
		<div class="width">
			<div id="nav">
				<div class="nav-inner width">
					<a href="../home">
						<div id="logo"></div>
						<div id="logo_name">What Would You Do Here?</div>
					</a>
					<div id="user_nav" class="nav">
						<ul>
							<a href="#"><li>Log in</li></a>
							<a href="#"><li>Sign up</li></a>
						</ul>
					</div>
					<div id="main_nav" class="nav">
						<ul>
							<a href="../locations" class="active"><li>Locations</li></a>
							<a href="../ideas"><li>Ideas</li></a>
							<a href="../projects"><li>Projects</li></a>
							<a href="../contact"><li>Contact</li></a>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div id="splash">
			<div class="splash_content">
				<h1>Search Locations</h1>
				<form method="POST">
					<input type="submit" name="simple_search" value="Search"></input>
					<input name="search" type="text" placeholder="Enter an address, city, zipcode, or feature" />
				</form>
			</div>
		</div>
		<div class="grid-inner width">
			<?php
			while ($row = $data->fetch_array(MYSQLI_ASSOC)) {
				if (isset($row["features"])) $row["features"] = implode(" | ", explode("[-]", $row["features"])); ?>
				<a href="propertyInfo.php?id=<?php echo $row["id"] ?>">
					<div class="location">
						<div class="grid-item">
							<?php if ($row["ideas"] > 0) { ?>
								<div class="ideas_count"><?php echo $row["ideas"] ?></div>
							<?php } ?>
							<div class="location_image" style="background-image: url(../helpers/location_images/<?php if (isset($row['image'])) echo $row['image']; else echo "no_image.jpg";?>);"></div>
							<div class="location_desc">
								<div class="address"><?php echo $row["mailing_address"] ?></div>
								<div class="features">
									<?php echo $row["features"] ?>
								</div>
							</div>
						</div>
					</div>
				</a>
		 	<?php }
			?>
		</div>
		<div id="pagination">
			<div class="grid-inner">
				<ul>
				<?php
					$starting_page = ($page - 5 > 0) ? $page - 5 : 1;
					$ending_page = ($page + 5 < ceil($total / $itemCount)) ? $page + 5 : ceil($total / $itemCount);

					for ($i = 0; $i <= 10 && $starting_page + $i <= $ending_page; $i++) { ?>
						<li><a <?php echo ($page == $starting_page + $i) ? 'class="active"' : "" ?>
							href="?page=<?php echo $starting_page + $i ?>"><?php echo $starting_page + $i ?></a>
						</li>
				<?php } ?>
				</ul>
			</div>
		</div>
		<div id="footer">
            <div class="grid-inner">
                &copy; Copyright WWYDH <?php echo date("Y") ?>
            </div>
        </div>
	</body>
</html>
