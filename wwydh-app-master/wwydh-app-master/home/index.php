<?php

    session_start();

    include "../helpers/conn.php";

    // BACKEND:0 change homepage location query to ORDER BY RAND() LIMIT 3
    $q = $conn->prepare("SELECT l.*, COUNT(DISTINCT i.id) AS ideas, GROUP_CONCAT(DISTINCT f.feature SEPARATOR '[-]') AS features FROM locations l LEFT JOIN ideas i ON i.location_id = l.id LEFT JOIN location_features f ON f.location_id = l.id WHERE l.id < 37 OR l.id = 3 GROUP BY l.id ORDER BY ideas DESC, RAND() LIMIT 4");
    $q->execute();

    $data = $q->get_result();
    $locations = [];

    while ($row = $data->fetch_array(MYSQLI_ASSOC)) {
        if (isset($row["features"])) $row["features"] = explode("[-]", $row["features"]);
        array_push($locations, $row);
    }

    $q = $conn->prepare("SELECT p.*, u.name AS leader, l.mailing_address AS address, l.image AS image FROM projects p LEFT JOIN users u ON p.leader_id = u.id LEFT JOIN ideas i ON p.idea_id = i.id LEFT JOIN locations l ON i.location_id = l.id");
    $q->execute();

    $data = $q->get_result();
    $projects = [];

    while ($row = $data->fetch_array(MYSQLI_ASSOC)) {
        array_push($projects, $row);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>WWYDH | <?php echo isset($_GET["contact"]) ? "Contact" : "Home" ?></title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,600i,700" rel="stylesheet">
        <link href="../helpers/header_footer.css" type="text/css" rel="stylesheet" />
        <link href="styles.css" type="text/css" rel="stylesheet" />
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzAMBl8WEWkqExNw16kEk40gCOonhMUmw" async defer></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script type="text/javascript">
            // convert location data from php to javascript using JSON
            var locations = jQuery.parseJSON('<?php echo str_replace("'", "\'", json_encode($locations)) ?>');

            function initMap() {
                // Create a map object and specify the DOM element for display.
                var map = new google.maps.Map(document.getElementById('map'), {
                    animation: google.maps.Animation.DROP,
                    center: {lat: parseFloat(locations[0].latitude), lng: parseFloat(locations[0].longitude)},
                    scrollwheel: false,
                    zoom: 14
                });

                $(locations).each(function() {
                    var marker = new google.maps.Marker({
                        map: map,
                        position: {lat: parseFloat(this.latitude), lng: parseFloat(this.longitude)},
                        address: this.mailing_address
                    });

                    marker.addListener("click", function() {
                        alert(this.address); // FRONTEND:10 change the map marker click listener to trigger location popup
                    })
                })
            }

        </script>

        <!-- scroll on click to how it works -->
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $("#see-how").click(function() {
                    $("html, body").animate({scrollTop: $("#how").offset().top}, 650);
                })
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function() {
                $("li.tablink").click(function() {
                    if (!$(this).hasClass("active")) {
                        // handle nav change
                        $("li.tablink").removeClass("active");
                        $(this).addClass("active");

                        // handle content change
                        $(".tabcontent").removeClass("active");
                        $(".tabcontent[data-tab=" + $(this).data("target") + "]").addClass("active");
                    }
                })
            })
       </script>
    </head>
    <body onload="initMap()">

        <?php
            // FRONTEND: remove this garbage style tag and externalize this stylesheet. This is just so I could see what I was doing
        ?>
    </head>
    <body>
        <div id="nav">
            <div class="nav-inner width">
                <a href="../home">
                    <div id="logo"></div>
                    <div id="logo_name">What Would You Do Here?</div>
                <div id="user_nav" class="nav">
                    <ul>
                        <a href="#"><li>Log in</li></a>
                        <a href="#"><li>Sign up</li></a>
                    </ul>
                </div>
                <div id="main_nav" class="nav">
                    <ul>
                        <a href="../locations"><li>Locations</li></a>
                        <a href="../ideas"><li>Ideas</li></a>
                        <a href="../projects"><li>Projects</li></a>
                        <a href="../contact"><li>Contact</li></a>
                    </ul>
                </div>
            </div>
        </div>
        <div id="mapContainer">
            <div id="map"></div>
            <div id="welcome">
                <div class="width">
                    <span id="see-how"><h1>See How it Works!</h1></span>
                    <div id="locationButton">Submit Location</div>
                </div>
            </div>
        </div>
        <div id="explore">
            <div class="width">
                <h1> EXPLORE </h1>
                <ul class="tab">
                    <li class="active tablink" data-target="1">Locations</li>
                    <li class="tablink" data-target="2">Projects</li>
                </ul>
                <div id="locations" class="tabcontent active" data-tab="1">
                    <?php
                    foreach($locations as $l) { ?>
                        <div class="location">
                            <div class="btn-group">
                                <div class="btn newidea"><a href="../ideas/new?location=<?php echo $l["id"] ?>">I have an idea</a></div>
                                <?php if ($l["ideas"] > 0) { ?> <div class="btn seeideas"><a href="../ideas?location=<?php echo $l["id"] ?>">See other ideas here</a></div> <?php } ?>
                                <div class="btn seelocation"><a href="../locations/propertyInfo.php?id=<?php echo $l["id"] ?>">View full location</a></div>
                            </div>
                            <div class="location_image" style="background-image: url(../helpers/location_images/<?php if (isset($l['image'])) echo $l['image']; else echo "no_image.jpg";?>);">
                                <?php if ($l["ideas"] > 0) { ?>
                                    <div class="ideas_count"><?php echo $l["ideas"] ?></div>
                                <?php } ?>
                            </div>
                            <div class="location_desc">
                                <div class="address"><?php echo $l["mailing_address"] ?></div>
                                <?php if (isset($l["features"])) { ?>
                                    <div class="features">
                                        <span>Features:</span>
                                            <ul>
                                                <?php foreach ($l["features"] as $f) { ?>
                                                    <li><?php echo $f ?></li>
                                                <?php } ?>
                                            </ul>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php }
                    ?>
                </div>
                <div id="projects" class="tabcontent" data-tab="2">
                    <?php
                    foreach ($projects as $p) { ?>
                        <div class="project">
                            <div class="project_image" style="background-image: url(../helpers/location_images/<?php if (isset($p['image'])) echo $p['image']; else echo "no_image.png";?>);"></div>
                            <div class="project_leader"><?php echo $p["leader"] ?></div>
                            <div class="address"><?php echo $p["address"] ?></div>
                            <div class="project_status">Status: <?php echo $p["completed"] == 0 ? "unfinished" : "finished" ?></div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div id="about">
            <div class="grid-inner width">
                <h1>ABOUT</h1>
                <div class="small-content">
                    WWYDH facilitates economic and social revitalization in Baltimore by combining the existing vacant and underutilized built infrastructure with the creative imagination and skills of people throughout the city. We begin by asking the simplest question:
                </div>

                <p>"What would you do here?"</p>
            </div>
        </div>
        <div id="how">
            <div class="grid-inner width">
                <h1 style="text-align:center"><font color="#3a3a3a">HOW IT WORKS</font></h1>
                <table>
                	<tr>
                		<th><img src="../images/idea.png" /></th>
                		<th><img src="../images/contributors.png" /></th>
                		<th><img src="../images/implementation.png" /></th>
                	</tr>
                	<tr>
                		<td>Submit an idea for a location to WWYDH. You can choose to anonymously submit the idea for someone else to eventually lead, or lead the idea yourself. </td>
                		<td>Ideas can be upvoted and downvoted, so the best rise to the top. A checklist of people and resources the idea will need is generated. Users can contribute to the idea by volunteering to fill one or more of the requirements on the list. When the list is complete, the idea can move to the next stage.</td>
                		<td>The idea becomes a project, and the project is implemented by everyone who pledged to contribute his or her time and skills to turn a vacant location into a useful space for the community.</td>
                	</tr>
                </table>
            </div>
        </div>
        <div id="footer">
            <div class="grid-inner">
                &copy; Copyright WWYDH <?php echo date("Y") ?>
            </div>
        </div>
    </body>
</html>
