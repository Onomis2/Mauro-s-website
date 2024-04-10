<?php

session_start();
if (!isset($_SESSION['username'])) {
    session_destroy();
    header("location: ../../database/userhandling.php>?message=2");
    exit();
}