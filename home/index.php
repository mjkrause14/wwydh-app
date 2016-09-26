<?php

    include "../helpers/conn.php";

    // BACKEND:0 change homepage location query to ORDER BY RAND() LIMIT 3
    $q = $conn->prepare("SELECT l.*, COUNT(DISTINCT i.id) AS ideas, GROUP_CONCAT(DISTINCT f.feature SEPARATOR '[-]') AS features FROM locations l LEFT JOIN ideas i ON i.location_id = l.id LEFT JOIN location_features f ON f.location_id = l.id GROUP BY l.id LIMIT 3");
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
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzAMBl8WEWkqExNw16kEk40gCOonhMUmw&callback=initMap" async defer></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script type="text/javascript">
            // convert location data from php to javascript using JSON
            var locations = jQuery.parseJSON('<?php echo str_replace("'", "\'", json_encode($locations)) ?>');

            function initMap() {
                // Create a map object and specify the DOM element for display.
                var map = new google.maps.Map(document.getElementById('map'), {
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

        <?php
            // FRONTEND: remove this garbage style tag and externalize this stylesheet. This is just so I could see what I was doing
        ?>
        <style type="text/css">
            .location_image, .project_image {
                height: 100px;
                width: 100px;
                background-position: center;
                background-size: cover;
                float: left;
            }

            .location {
                width: 100%;
                clear: both;
                margin-bottom: 10px;
                padding-bottom: 10px;
                border-bottom: 1px solid rgba(0, 0, 0, 0.05);
                overflow: hidden;
            }

            .location:last-child {
                border-bottom-width: 0px;
            }
             #mapContainer{
              height:500px;
              position:relative;
            }
            #welcome{
            height: 75px;
            background-color: #418040;
            z-index: 1;
            opacity: 0.9;
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            }
            h1{
            color: white;
            font-family: "Open Sans";
            font-size: large;
            text-decoration: underline;
            float: left;
            vertical-align: middle;
            position: relative;
            top: 10px;
            left: 20px;

            }
            #locationButton{
            background-color: white;
            color: #418040;
            border: 2px solid #418040;
            font-family: "Open Sans";
            float: right;
            font-size: 22px;
            border-radius: 8px;
            padding: 8px 4px;
            position: relative;
            top: 13px;
            left: -30px;
            }
            #map{
            height: 500px;
            position: relative;
            }
        </style>
    </head>
    <body>
        <div id="nav">
            <div id="logo"></div>
            <div id="main_nav"></div>
            <div id="user_nav"></div>
        </div>
        <div id="mapContainer">
          <div id="map"></div>
          <div id="welcome">
            <h1>See How it Works!</h1>
            <div id="locationButton">Submit Location</div>
          </div>
        </div>
        <div id="explore">
            <div id="locations">
                <?php
                foreach($locations as $l) { ?>
                    <div class="location">
                        <?php if ($l["ideas"] > 0) { ?>
                            <div class="ideas_count"><?php echo $l["ideas"] ?></div>
                        <?php } ?>
                        <div class="location_image" style="background-image: url(../helpers/location_images/<?php if (isset($l['image'])) echo $l['image']; else echo "pin.png";?>);"></div>
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
                        <div class="btn"><a href="../newidea?location=<?php echo $l["id"] ?>">I have an idea</a></div>
                        <?php if ($l["ideas"] > 0) { ?> <div class="btn"><a href="../ideas?location=<?php echo $l["id"] ?>">See other ideas here</a></div> <?php } ?>
                        <div class="btn"><a href="../locattion?id=<?php echo $l["id"] ?>">View full location</a></div>
                    </div>
                <?php }
                ?>
            </div>
            <div id="projects">
                <?php
                foreach ($projects as $p) { ?>
                    <div class="project">
                        <div class="project_image" style="background-image: url(../helpers/location_images/<?php if (isset($p['image'])) echo $p['image']; else echo "pin.png";?>);"></div>
                        <div class="project_leader"><?php echo $p["leader"] ?></div>
                        <div class="address"><?php echo $p["address"] ?></div>
                        <div class="project_status">Status: <?php echo $p["completed"] == 0 ? "unfinished" : "finished" ?></div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div id="about"></div>
        <div id="how"></div>
        <div id="contact"></div>
        <div id="footer"></div>
    </body>
</html>
