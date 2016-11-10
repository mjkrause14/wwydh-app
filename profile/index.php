<?php

    session_start();

    include "../helpers/conn.php";

	$userInfoRow = null;
  $usrRankVal = null;

	if (isset($_GET["usrID"]))
	{
		$usrQuery = "SELECT * from user_profiles where id=" . $_GET["usrID"];
		$queryResult = $conn->query($usrQuery);
		$userInfoRow = @mysqli_fetch_array($queryResult);
	}
  if(isset($_GET["usrID"]))
  {
  $usrRankQry = "SELECT rank from user_profiles where id=" . $_GET["usrID"];
  $rqueryResult = $conn->query($usrRankQry);
  $rankRow = @mysqli_fetch_array($rqueryResult);
  }
  if(isset($_GET["usrID"]))
  {
  $comPlete = "SELECT completed from projects where id=" . $_GET["usrID"];
  $rComP = $conn->query($comPlete);
  $rCompRow = @mysqli_fetch_array($rComP);
  }
  if(isset($_GET["usrID"]))
  {
  $name = "SELECT first from users where id=" . $_GET["usrID"];
  $name1 = $conn->query($name);
  $nameRow = @mysqli_fetch_array($name1);
  }





	function writeSkillSection($image_path, $skillname, $description)
	{
		echo "<div class=\"skillSection\">\n\t<img class=\"skillImg\" src=\"" . $image_path . "\"></img>\n\t<div class=\"skillLabel\">" . $skillname . "</div>\n\t<span class=\"tooltiptext\">" . $description . "</span>\n</div>";
	}
  function printRank($usrRankVal)
  {
   echo $usrRankVal;
  }
	//if (isset($_SESSION[)
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Profile (DW's Copied Header)</title>
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
	<div id="MySkills" class="BoxContainer">
		<div class="BoxLabel">
			Contributions
		</div>
		<?php
			//TODO: Use SESSION instead of GET
			if (isset($_GET["loggedIn"]))
			{

			}
			$userSkillQuery = "SELECT skill_arr from user_profiles where id=" . $_GET["usrID"];
			$queryResult = $conn->query($userSkillQuery);
			$skillsArrRow = @mysqli_fetch_array($queryResult);

			$skills = explode(";", $skillsArrRow['skill_arr']);


			foreach ($skills as $currentSkill)
			{
				$skillsQuery = "SELECT * from user_skills where id=" . $currentSkill;
				$skillResult = $conn->query($skillsQuery);
				$skillsRow = @mysqli_fetch_array($skillResult);

				writeSkillSection($skillsRow['img'], $skillsRow['skill_name'], $skillsRow['skill_description']);
			}
		?>
    	</div>

    <div id="AboutMe" class="BoxContainer">
  		<div class="BoxLabel">
  			Rank
  		</div>
      <div class="BoxContent">
        <?php
        echo $rankRow['rank'];
        ?>
      </div>
      </div>

      <div id="AboutMe" class="BoxContainer">
    		<div class="BoxLabel">
    			Completed Projects
    		</div>
        <div class="BoxContent">
          <?php
          echo $rCompRow['completed'];
          ?>
        </div>
        </div>
        <div id="AboutMe" class="BoxContainer">
          <div class="BoxLabel">
            Name
          </div>
          <div class="BoxContent">
            <?php
            echo $nameRow['first'];
            ?>
          </div>
          </div>

	<div id="AboutMe" class="BoxContainer">
		<div class="BoxLabel">
			About Me
		</div>
		<div class="BoxContent">
			<?php
				echo $userInfoRow['about_me'];
			?>
		</div>
	</div>
	</body>
</html>
