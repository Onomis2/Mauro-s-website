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
</head>

<body>
    <a href=../database/userhandling.php>Logout</a>
</body>
<?php include_once("universalpages/navbar.php"); ?>
<p>If statement user logged in for now, later maybe user = admin</p>
<p>False = blockade page, you must be loggedin/admin to have access to this function</p>
<p>True = admin panel in which you are able to add, delete and edit both tags and images.</p>
</html>