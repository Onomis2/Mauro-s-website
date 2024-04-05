<?php

include "universalpages/activate.php";
require_once("../database/connection.php");
$currentPage = 'insert';
$tagnum = 1;

$tagdata = $dbh->prepare("SELECT * FROM tags");
$tagdata->execute();
$tags = $tagdata->fetchAll(PDO::FETCH_ASSOC);

if (!empty($_POST['addTag'])) {
    if (!empty($_POST['tagName']) && !empty($_POST['tagColor'])) {
        $tagName = $_POST['tagName'];
        $tagColor = $_POST['tagColor'];

        $sthInsert = $dbh->prepare(
            "INSERT INTO tags (tag_name, tag_color)
            VALUES (:tag_name, :tag_color)"
        );

        $sthInsert->bindParam(':tag_name', $tagName);
        $sthInsert->bindParam(':tag_color', $tagColor);

        try {
            $sthInsert->execute();
            $outputMessage = "Successfully added new tag to the database with name \"$tagName\" and color <span style=\"color: " . htmlspecialchars($tagColor) . ";\">$tagColor</span>";
            $outputMessageEncoded = urlencode($outputMessage);
            header("Location: insert.php?error=$outputMessageEncoded");
            exit();
        } catch (PDOException $e) {
            $outputMessage = 'Insert failed: ' . $e->getMessage();
        }
    } else {
        $outputMessage = "Error adding tag. Both name and color are required.";
    }
} elseif (empty($_POST['addImage']) && !empty($_POST['addTag'])) {
    $outputMessage = "Error adding tag. No name was entered.";
} elseif (!empty($_POST["addImage"])) {
    $imageSource = $_POST['imageSource'];

    if (!empty($_FILES['imageImage']['tmp_name']) && is_uploaded_file($_FILES['imageImage']['tmp_name'])) {
        $imageData = file_get_contents($_FILES['imageImage']['tmp_name']);

        $stmt = $dbh->prepare("INSERT INTO images (image, source) VALUES (:image, :source)");
        $stmt->bindParam(':image', $imageData, PDO::PARAM_LOB);
        $stmt->bindParam(':source', $imageSource);

        try {
            $stmt->execute();
            $imageId = $dbh->lastInsertId();

            if (!empty($_POST['checktag'])) {
                foreach ($_POST['checktag'] as $tagId) {
                    $tagId = (int)$tagId;
                    $tagField = 'tag' . $tagnum++;
                    $tagUpdate = $dbh->prepare("UPDATE images SET $tagField = :tagId WHERE image_id = :imageId");
                    $tagUpdate->bindParam(':imageId', $imageId);
                    $tagUpdate->bindValue(':tagId', $tagId);
                    $tagUpdate->execute();
                }
            }

            $outputMessage = "Successfully added new image to the database.";
            header("location: insert.php?error=$outputMessage");
            exit();
        } catch (PDOException $e) {
            $outputMessage = "Error adding image: " . $e->getMessage();
        }
    } else {
        $outputMessage = "Error adding image: No image file uploaded.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/content.css">
</head>

<body>
    <?php include_once("universalpages/navbar.php"); ?>
    <!--If statement user logged in for now, later maybe user = admin
    False = blockade page, you must be loggedin/admin to have access to this function
    True = admin panel in which you are able to add, delete and edit both tags and images.
    Have 2 divs next to each other, left for adding tags, right for adding images. Make sure to add correct handling so that errors pop up whenever a required value is not added or invalid. -->

    <!--Later interchangable with $_session["admin"] if needed, this code is redundant for now as this page is unaccesible for logged out users currently.-->
    <?php if (!isset($_SESSION["username"])) : ?>
        <div>
            <h1>You have to be logged in to view this page</h1>
        </div>
    <?php else : ?>
        <div>
            <h1>Wecome, <?= $_SESSION["username"]; ?>!</h1>
        </div>
        <?php if (isset($outputMessage)) : ?>
            <h1 class="error"><?= $outputMessage; ?></h1>
        <?php elseif (isset($_GET['error'])) : ?>
            <h1 class="error"><?= $_GET['error']; ?></h1>
        <?php endif; ?>
        <div class="insertTag">
            <h1>Add a new tag to the database</h1>
            <form action="insert.php" method="post">
                <input type=hidden name=addTag id=addTag value=true>
                <p>Tag name:<input type="text" id="tagName" name="tagName" placeholder="Name"></p>
                <p>Tag color:<input type="color" id="tagColor" name="tagColor" /><label for="tagColor"></label> (Recommended to pick lighter colours)</p>
                <br>
                <input type="submit" value="Add Tag!">
            </form>
        </div>

        <div class="insertImage">
            <h1>Add a new image to the database</h1>
            <form action="insert.php" method="post" enctype="multipart/form-data">
                <input type=hidden name=addImage id=addImage value=true>
                <p>Image source:<input type=text placeholder="person, location or website" name=imageSource id=imageSource></p>
                <p>Image: <input type=file name=imageImage id=imageImage></p>
                <p>Select tags (maximum of 20)</p>
                <?php foreach ($tags as $tag) : ?>
                    <div class="tag">
                        <input type="checkbox" value="<?= $tag['tag_id']; ?>" name="checktag[]">
                        <?= $tag['tag_name']; ?>
                    </div>
                <?php endforeach; ?>
                <p><input type="submit" value="Add Image!"></p>
            </form>
        </div>
    <?php endif; ?>
</body>

</html>