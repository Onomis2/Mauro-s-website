<?php

require_once('connection.php');

if (isset($_GET['id'])) {
    $stmt = $dbh->prepare("SELECT image FROM images WHERE image_id = ?");
    $stmt->execute([$_GET['id']]);
    $Image = $stmt->fetchColumn();

    header("Content-type: image/png");
    echo $Image;
    exit();
}
