<?php

    session_start();

    if (isset($_SESSION["user"]) && isset($_POST)) {
        include "../conn.php";

        $q = $conn->prepare("INSERT INTO plans (title, location_id, idea_id, creator_id) VALUES (?, ?, ?, ?)");
        $q->bind_param("ssss", $_POST["title"], $_POST["location"], $_POST["idea"], $_SESSION["user"]["id"]);
        $q->execute();

        echo "1";
    }
