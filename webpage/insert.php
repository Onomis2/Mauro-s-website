<?php

include "universalpages/activate.php";
$currentPage = 'insert';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>
    <?php include_once("universalpages/navbar.php"); ?>
    <p>If statement user logged in for now, later maybe user = admin</p>
    <p>False = blockade page, you must be loggedin/admin to have access to this function</p>
    <p>True = admin panel in which you are able to add, delete and edit both tags and images.</p>
    <p>Have 2 divs next to each other, left for adding tags, right for adding images. Make sure to add correct handling so that errors pop up whenever a required value is not added or invalid.</p>

        <!--Later interchangable with $_session["admin"] if needed, this code is redundant for now as this page is unaccesible for logged out users currently.-->
    <?php if (!isset($_SESSION["username"])) : ?>
        <div>
            <h1>You have to be logged in to view this page</h1>
        </div>
    <?php else : ?>
        <div>
            <h1>Wecome, <?= $_SESSION["username"]; ?>!</h1>
            <form>
                
            </form>
        </div>
    <?php endif; ?>
</body>
</html>