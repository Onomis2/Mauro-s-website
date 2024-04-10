<?php

include "universalpages/activate.php";
require_once("../database/connection.php");
$currentPage = 'browse';

if (isset($_POST['checktag'])) {
    $tags = $_POST['checktag'];
    $tagsCount = count($tags);

    $placeholders = rtrim(str_repeat('?, ', $tagsCount), ', ');

    $query = "SELECT * FROM images WHERE ";
    for ($i = 0; $i < $tagsCount; $i++) {
        $query .= "FIND_IN_SET(?, tag1) OR FIND_IN_SET(?, tag2) OR FIND_IN_SET(?, tag3) OR FIND_IN_SET(?, tag4) OR FIND_IN_SET(?, tag5) OR FIND_IN_SET(?, tag6) OR FIND_IN_SET(?, tag7) OR FIND_IN_SET(?, tag8) OR FIND_IN_SET(?, tag9) OR FIND_IN_SET(?, tag10) OR FIND_IN_SET(?, tag11) OR FIND_IN_SET(?, tag12) OR FIND_IN_SET(?, tag13) OR FIND_IN_SET(?, tag14) OR FIND_IN_SET(?, tag15) OR FIND_IN_SET(?, tag16) OR FIND_IN_SET(?, tag17) OR FIND_IN_SET(?, tag18) OR FIND_IN_SET(?, tag19) OR FIND_IN_SET(?, tag20) OR ";
    }
    $query = rtrim($query, 'OR ');
    $query .= " ORDER BY image_id DESC";

    $imagedata = $dbh->prepare($query);

    $boundParams = [];
    foreach ($tags as $tag) {
        for ($i = 0; $i < 20; $i++) {
            $boundParams[] = $tag;
        }
    }

    $imagedata->execute($boundParams);

    $images = $imagedata->fetchAll(PDO::FETCH_ASSOC);
} else {
    $imagedata = $dbh->prepare("SELECT * FROM images ORDER BY image_id DESC");
    $imagedata->execute();
    $images = $imagedata->fetchAll(PDO::FETCH_ASSOC);
}

$tagdata = $dbh->prepare("SELECT * FROM tags");
$tagdata->execute();
$tags = $tagdata->fetchAll(PDO::FETCH_ASSOC);

$isChecked = false;
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse</title>
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/content.css">
    <link rel="icon" href="../images/Kirby_logo" type="image/x-icon">
</head>

<body>
    <?php include_once "universalpages/navbar.php"; ?>
    <p>Search bar and filter tag</p>
    <form action="images.php" method="post">
        <?php foreach ($tags as $tag) : ?>
            <div class=tag>
                <?php if (isset($_POST["checktag"])) {
                    $isChecked = in_array($tag['tag_id'], $_POST['checktag']);
                }
                ?>
                <input type="checkbox" value="<?= $tag['tag_id']; ?>" name="checktag[]" <?php if ($isChecked) {
                                                                                                            echo "checked='checked'";
                                                                                                        }; ?>>
                <?= $tag['tag_name']; ?>
            </div>
        <?php endforeach; ?>
        <br>
        <input type="submit" value="Submit">
    </form>

    <?php foreach ($images as $image) : ?>
    <div class="image">
        <p>Source: <?= $image['source']; ?></p>
        <p><a href=../database/imagehandling.php?id=<?= $image['image_id']; ?>><img src="../database/imagehandling.php?id=<?= $image['image_id']; ?>" alt="" width="300px" height="200px" class=actualimage></a></p>
        <p>Tags: <?php 
            for ($i = 1; $i <= 20; $i++) {
                if (!empty($image["tag$i"])) {
                    $tagId = $image["tag$i"];
                    $tagName = '';
                    foreach ($tags as $tag) {
                        if ($tag['tag_id'] == $tagId) {
                            $tagName = $tag['tag_name'];
                            break;
                        }
                    }
                    echo '<div class="tag">' . $tagName . "</div>";
                } else {
                    break;
                }
            }
        ?></p>
    </div>
<?php endforeach; ?>


</body>

</html>