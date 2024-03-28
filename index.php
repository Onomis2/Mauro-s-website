<?php

session_start();
if (isset($_SESSION["username"])) {
    header("location: webpage/home.php");
    exit();
} else {
    header("location: database/userhandling.php");
    exit();
}
?>