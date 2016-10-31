<?php

    session_start();

    if (!isset($_SESSION["user"])) {
        // user isn't logged in, redirect
        header("Location: ../home");
    }

    $points = 1002;
?>

<!DOCTYPE html>
<html>
    <head>
        <title>WWYDH Dashboard | <?php echo $_SESSION["user"]["first"] ?></title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://use.fontawesome.com/42543b711d.js"></script>
        <script src="../helpers/globals.js" type="text/javascript"></script>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,600i,700" rel="stylesheet">
        <link href="../helpers/header_footer.css" rel="stylesheet" type="text/css" />
        <link href="styles.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div id="nav">
            <div class="nav-inner width clearfix">
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
                        <a href="../ideas"><li>Ideas</li></a>
                        <a href="../plans"><li>Plans</li></a>
                        <a href="../projects"><li>Projects</li></a>
                    </ul>
                </div>
            </div>
        </div>
        <div id="wrapper">
            <div id="content"></div>
            <div id="sidebar"></div>
        </div>
    </body>
</html>
