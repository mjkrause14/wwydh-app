<?php

    session_start();
    
    if (!isset($_SESSION["user"])) {
        // user isn't logged in, redirect
        header("Location: ../home")
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $first ?></title>
        <link href="styles.css" rel="stylesheet" type="text/css" />
    </head>
    <body></body>
</html>
