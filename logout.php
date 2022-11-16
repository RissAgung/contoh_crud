<?php

    session_start();

    session_destroy();

    setcookie('login', null, time() - 120);
    setcookie('level', null, time() - 120);
    header("Location: login.php");

?>