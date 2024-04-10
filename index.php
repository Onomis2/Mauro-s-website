<?php

session_start();
if (!isset($_SESSION['admin'])) {
    session_destroy();
    header("location: database/userhandling.php?message=1");
}
if (isset($_SESSION["username"])) {
    header("location: webpage/home.php");
    exit();
} else {
    header("location: database/userhandling.php");
    exit();
}