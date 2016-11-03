<?php

	session_start();

	include "../helpers/paginate.php";
	include "../helpers/vars.php";
	include "../helpers/conn.php";

	$theQuery = "";
	$result = null;

	// count all records for pagination
	$q = $conn->prepare("SELECT COUNT(i.id) as total FROM ideas i");
	$q->execute();

	$total = $q->get_result()->fetch_array(MYSQLI_ASSOC)["total"];
	$offset = $itemCount * ($page - 1);

	$id = isset($_SESSION["user"]["id"]) ? $_SESSION["user"]["id"] : 0;

	// BACKEND:10 change locations search code to prepared statements to prevent SQL injection
	if (isset($_GET["isSearch"])) {
		$theQuery = "SELECT * FROM `locations` WHERE `building_address` LIKE '%{$_GET["sAddress"]}%' AND `building_address` LIKE '%{$_GET["sAddress"]}%' AND `block` LIKE '%{$_GET["sBlock"]}%' AND `lot` LIKE '%{$_GET["sLot"]}%' AND `zip_code` LIKE '%{$_GET["sZip"]}%' AND `city` LIKE '%{$_GET["sCity"]}%' AND `neighborhood` LIKE '%{$_GET["sNeighborhood"]}%' AND `police_district` LIKE '%{$_GET["sPoliceDistrict"]}%' AND `council_district` LIKE '%{$_GET["sCouncilDistrict"]}%' AND `longitude` LIKE '%{$_GET["sLongitude"]}%' AND `latitude` LIKE '%{$_GET["sLatitude"]}%' AND `owner` LIKE '%{$_GET["sOwner"]}%' AND `use` LIKE '%{$_GET["sUse"]}%' AND `mailing_address` LIKE '%{$_GET["sMailingAddr"]}%'";
	} else if (isset($_GET["location"])) {
		$q = $conn->prepare("SELECT u.name AS `name`, i.*, GROUP_CONCAT(cc.description SEPARATOR '[-]') as `checklist`, l.mailing_address, l.image FROM ideas i LEFT JOIN users u ON u.id = i.leader_id
		LEFT JOIN locations l ON i.location_id = l.id
		LEFT JOIN checklists c ON c.idea_id = i.id
		LEFT JOIN checklist_items cc ON cc.checklist_id = c.id
		WHERE cc.contributer_id IS NULL AND i.location_id = {$_GET["location"]} GROUP BY i.id");
	} else {
		$q = $conn->prepare("SELECT i.*, COUNT(up_i.id) AS `upvotes`, COUNT(down_i.id) AS `downvotes`, (COUNT(up_i.id) - COUNT(down_i.id)) AS `vote coef`, COUNT(up_i_u.id) AS `upvoted`, COUNT(down_i_u.id) AS `downvoted` FROM ideas i LEFT JOIN
		upvotes_ideas up_i ON up_i.idea_id = i.id LEFT JOIN downvotes_ideas down_i ON down_i.idea_id = i.id LEFT JOIN upvotes_ideas
		up_i_u ON up_i_u.user_id = $id AND up_i_u.idea_id = i.id LEFT JOIN downvotes_ideas down_i_u ON down_i_u.user_id = $id AND down_i_u.idea_id = i.id GROUP BY i.id ORDER BY `vote coef` DESC LIMIT $itemCount OFFSET $offset");
	}

	$q->execute();
	$data = $q->get_result();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>All Ideas</title>
		<link href="../helpers/header_footer.css" type="text/css" rel="stylesheet" />
		<link href="../helpers/splash.css" type="text/css" rel="stylesheet" />
		<link href="styles.css" type="text/css" rel="stylesheet" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<script src="https://use.fontawesome.com/42543b711d.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<script src="../helpers/globals.js" type="text/javascript"></script>
		<script src="scripts.js" type="text/javascript"></script>
	</head>
	<body>
		<div class="width">
			<div id="nav">
	            <div class="nav-inner width clearfix <?php if (isset($_SESSION['user'])) echo 'loggedin' ?>">
	                <a href="../home">
	                    <div id="logo"></div>
	                    <div id="logo_name">What Would You Do Here?</div>
	                    <div class="spacer"></div>
	                </a>
	                <div id="user_nav" class="nav">
	                    <?php if (!isset($_SESSION["user"])) { ?>
	                        <ul>
	                            <a href="../login"><li>Log in</li></a>
	                            <a href="#"><li>Sign up</li></a>
	                            <a href="../contact"><li>Contact</li></a>
	                        </ul>
	                    <?php } else { ?>
	                        <div class="loggedin">
	                            <span class="click-space">
	                                <span class="chevron"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
	                                <div class="image" style="background-image: url(../helpers/user_images/<?php echo $_SESSION["user"]["image"] ?>);"></div>
	                                <span class="greet">Hi <?php echo $_SESSION["user"]["first"] ?>!</span>
	                            </span>

	                            <div id="nav_submenu">
	                                <ul>
	                                    <a href="../dashboard"><li>Dashboard</li></a>
	                                    <a href="../profile"><li>My Profile</li></a>
	                                    <a href="../helpers/logout.php?go=home"><li>Log out</li></a>
	                                </ul>
	                            </div>
	                        </div>
	                    <?php } ?>
	                </div>
	                <div id="main_nav" class="nav">
	                    <ul>
	                        <a href="../locations"><li>Locations</li></a>
	                        <a href="../ideas" class="active"><li>Ideas</li></a>
	                        <a href="../plans"><li>Plans</li></a>
	                        <a href="../projects"><li>Projects</li></a>
	                    </ul>
	                </div>
	            </div>
	        </div>
		</div>
		<div id="splash">
			<div class="splash_content">
				<h1>Search Ideas</h1>
				<form method="POST">
					<input type="submit" name="simple_search" value="Search"></input>
					<input name="search" type="text" placeholder="Enter a category or search keywords" />
				</form>
			</div>
		</div>
		<div class="grid-inner width">
			<?php
			while ($row = $data->fetch_array(MYSQLI_ASSOC)) {
				if (isset($row["checklist"])) $row["checklist"] = explode("[-]", $row["checklist"]); ?>

				<div class="idea
				<?php if (isset($row["owner"])) echo "mine" ?>"
				data-idea="<?php echo $row["id"] ?>">
					<div class="grid-item width">
						<div class="vote">
							<div class="upvote <?php if ($row["upvoted"] == 1) echo "me"; ?>">
								<div class="vote_count"><?php echo $row["upvotes"] ?></div>
								<i class="fa fa-thumbs-up" aria-hidden="true"></i>
							</div>
							<div class="downvote <?php if ($row["downvoted"] == 1) echo "me"; ?>">
								<i class="fa fa-thumbs-down" aria-hidden="true"></i>
								<div class="vote_count"><?php echo $row["downvotes"] ?></div>
							</div>
							<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
						</div>
						<div class="idea_image_wrapper">
							<i class="fa <?php echo $location_categories[$row['category']]['fa-icon'] ?>"></i>
							<div class="overlay"></div>
							<div class="idea_image" style="background-image: url(../helpers/category_images/<?php if (isset($row['category'])) echo $location_categories[$row['category']]['image']; else echo "no_image.jpg";?>);"></div>
						</div>
						<div class="idea_desc">
							<div class="title"><?php echo $row["title"] ?></div>
							<div class="category"><?php echo $location_categories[$row['category']]["title"] ?></div>
							<div class="description"><?php echo $row["description"] ?></div>
							<?php /* ?>
							<?php if (count($row["checklist"]) > 0) { ?>
								<div class="checklist">
									<span>Contributors Needed: </span>
									<ul>
										<?php for ($i = 0; $i < count($row["checklist"]) && $i < 4; $i++) { ?>
											<li><?php echo $row["checklist"][$i] ?></li>
										<?php } ?>
										<?php if (count($row["checklist"]) > 4) { ?>
											<span><?php echo count($row["checklist"]) - 4 ?>+ more</span>
										<?php } ?>
									</ul>
								</div>
							<?php } ?>
							<?php */ ?>
						</div>
					</div>
				</div>
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
