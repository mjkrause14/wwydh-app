<?php
    $user = $_POST["username"];
    $pass = $_POST["password"];

    $login = crypt(($user.$pass), '$2a$07$QWERTYUIOPpoiuytrewASDFGHJKLLKJHGFDS$');
?>
