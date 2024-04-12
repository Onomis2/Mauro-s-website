<?php

include "universalpages/activate.php";
require_once("../database/connection.php");
if ($_SESSION['admin'] !== "YES") {
    session_destroy();
    header("location: ../database/userhandling.php?message=3");
}
$currentPage = 'insert';

$tagdata = $dbh->prepare("SELECT * FROM tags WHERE tag_id = :id");
$tagdata->bindParam(':id', $_GET['id']);
$tagdata->execute();
$tags = $tagdata->fetchAll(PDO::FETCH_ASSOC);

$allTagsData = $dbh->prepare("SELECT * FROM tags");
$allTagsData->execute();
$allTags = $allTagsData->fetchAll(PDO::FETCH_ASSOC);

$imagedata = $dbh->prepare("SELECT * FROM images WHERE image_id = :id");
$imagedata->bindParam(':id', $_GET['id']);
$imagedata->execute();
$images = $imagedata->fetchAll(PDO::FETCH_ASSOC);


if ($_GET['type'] == 'tag') {
    if (!empty($_POST['tagName']) && !empty($_POST['tagColor'])) {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $tagName = htmlspecialchars($_POST['tagName']);
        $tagColor = htmlspecialchars($_POST['tagColor']);

        $sthUpdate = $dbh->prepare(
            "UPDATE tags SET tag_name = :tag_name, tag_color = :tag_color WHERE tag_id = :id"
        );

        $sthUpdate->bindParam(':tag_name', $tagName);
        $sthUpdate->bindParam(':tag_color', $tagColor);
        $sthUpdate->bindParam(':id', $id);

        try {
            $sthUpdate->execute();
            $outputMessage = "Successfully updated tag with name \"$tagName\" and color <span style=\"color: " . htmlspecialchars($tagColor) . ";\">$tagColor</span>";
            $outputMessageEncoded = urlencode($outputMessage);
            header("Location: insert.php?error=$outputMessageEncoded");
            exit();
        } catch (PDOException $e) {
            $outputMessage = 'Insert failed: ' . $e->getMessage();
        }
    } elseif ($_GET['temp'] == 'new' && !isset($_POST['addTag'])) {
        $outputMessage = "Edit or delete this tag";
    } else {
        $outputMessage = "Error adding tag. A name is required.";
    }
} elseif ($_GET['type'] == 'img') {
    if (!empty($_FILES['imageImage']['tmp_name']) && is_uploaded_file($_FILES['imageImage']['tmp_name'])) {
        $imageData = file_get_contents($_FILES['imageImage']['tmp_name']);

        $imageSource = htmlspecialchars($_POST['imageSource']);
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        $stmt = $dbh->prepare("UPDATE images SET image = :image, source = :source WHERE image_id = :id");
        $stmt->bindParam(':image', $imageData, PDO::PARAM_LOB);
        $stmt->bindParam(':source', $imageSource);
        $stmt->bindParam(':id', $id);

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
    <title>Edit</title>
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/content.css">
    <link rel="icon" href="../images/Kirby_logo.png" type="image/x-icon">
</head>

<body>

    <?php if (isset($_GET['error'])) : ?>
        <h1 class="error"><?= $_GET['error']; ?></h1>
    <?php elseif (isset($outputMessage)) : ?>
        <h1 class="error"><?= $outputMessage; ?></h1>
    <?php endif; ?>

    <?php if ($_GET['type'] == 'tag') : ?>
        <form method=post>
            <input type=hidden name=addTag value=addTag>
            <input type=hidden name=id value=<?= $_GET['id']; ?>>
            <p>Tag name:<input type="text" id="tagName" name="tagName" value=<?= $tags[0]['tag_name']; ?> placeholder=<?= $tags[0]['tag_name']; ?>></p>
            <p>Tag color:<input type="color" id="tagColor" name="tagColor" value="<?= $tags[0]['tag_color']; ?>" /> (Recommended to pick lighter colours)</p>
            <br>
            <input type="submit" value="Update Tag!">
        </form>

    <?php elseif ($_GET['type'] == 'img') : ?>

        <form method="post" enctype="multipart/form-data">
            <input type=hidden name=addImage id=addImage value=true>
            <p>Image source:<input type=text value="<?= $images[0]['source']; ?>" name=imageSource id=imageSource></p>
            <p>Image: <input type=file name=imageImage id=imageImage></p>
            <p>Current image: </p>
            <p><a href=../database/imagehandling.php?id=<?= $_GET['id']; ?>><img src="../database/imagehandling.php?id=<?= $_GET['id']; ?>" alt="" width="300px" height="200px" class=actualimage></a></p>
            <p>Current active tags: <?php
                                    for ($i = 1; $i <= 20; $i++) {
                                        if (!empty($images[0]["tag$i"])) {
                                            $tagId = $images[0]["tag$i"];
                                            $tagName = '';
                                            foreach ($allTags as $tag) {
                                                if ($tag['tag_id'] == $tagId) {
                                                    $tagName = $tag['tag_name'];
                                                    break;
                                                }
                                            }
                                            echo '<div class="tag" style="background-color: ' . $tag['tag_color'] . '">' . $tagName . '</div>';
                                        } else {
                                            break;
                                        }
                                    }
                                    ?></p>
            <p>Select tags (maximum of 20)</p>
            <?php foreach ($allTags as $tag) : ?>
                <div class="tag" style="background-color: <?= $tag['tag_color']; ?>">
                    <input type="checkbox" value="<?= $tag['tag_id']; ?>" name="checktag[]" <?php switch ($tag['tag_id']) {
    case $images[0]['tag1']:
        echo 'checked="checked"';
        break;
    case $images[0]['tag2']:
        echo 'checked="checked"';
        break;
    case $images[0]['tag3']:
        echo 'checked="checked"';
        break;
    case $images[0]['tag4']:
        echo 'checked="checked"';
        break;
    case $images[0]['tag5']:
        echo 'checked="checked"';
        break;
    case $images[0]['tag6']:
        echo 'checked="checked"';
        break;
    case $images[0]['tag7']:
        echo 'checked="checked"';
        break;
    case $images[0]['tag8']:
        echo 'checked="checked"';
        break;
    case $images[0]['tag9']:
        echo 'checked="checked"';
        break;
    case $images[0]['tag10']:
        echo 'checked="checked"';
        break;
    case $images[0]['tag11']:
        echo 'checked="checked"';
        break;
    case $images[0]['tag12']:
        echo 'checked="checked"';
        break;
    case $images[0]['tag13']:
        echo 'checked="checked"';
        break;
    case $images[0]['tag14']:
        echo 'checked="checked"';
        break;
    case $images[0]['tag15']:
        echo 'checked="checked"';
        break;
    case $images[0]['tag16']:
        echo 'checked="checked"';
        break;
    case $images[0]['tag17']:
        echo 'checked="checked"';
        break;
    case $images[0]['tag18']:
        echo 'checked="checked"';
        break;
    case $images[0]['tag19']:
        echo 'checked="checked"';
        break;
    case $images[0]['tag20']:
        echo 'checked="checked"';
        break;
    default:
        break;
} ?>>
                    <?= $tag['tag_name']; ?>
                </div>
            <?php endforeach; ?>
            <p><input type="submit" value="Update Image!"></p>
        </form>
    <?php else : ?>
        <h1>An error has occured, please go back to the previous page.</h1>
    <?php endif; ?>
    <?php if ($_GET['type'] == 'tag') : ?>
        <p><a href=insert.php><input type=button value="Back to previous page"></a>
        <p>
        <?php else : ?>
        <p><a href=images.php><input type=button value="Back to previous page"></a>
        <p>
        <?php endif; ?>
</body>

</html>
