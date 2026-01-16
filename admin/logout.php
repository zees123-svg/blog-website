<?php

    include '../config.php';
    session_start();
    session_unset();
    session_destroy();
    header('location: http://localhost/Blog/login.php');
    exit();

?>