<?php

// Sets error to null and establishes connection to database

$error = null;
require_once 'connection.php';

// If a post has been sent this code executes

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Converts post into regular variables

    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];

    // Checks if a given entry already exists in the database

    $stmt = $dbh->prepare("SELECT * FROM users WHERE username=:username ");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    // Code that throws errors at the user if the given input is duplicate

    if ($existingUser) {
        $error = "Username already exists.";
    } elseif (empty($username) || empty($password)) {
        $error = "Please do not leave username or password empty";
    } else {

        // Send given input to the database if no errors have been caught

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sthUpdate = $dbh->prepare(
            "INSERT INTO users (username, password) VALUES (:username, :password)"
        );

        $sthUpdate->bindParam(':username', $username); // Bind username parameter
        $sthUpdate->bindParam(':password', $hashedPassword); // Bind password parameter

        // Execute and redirect user

        $sthUpdate->execute();
        header("Location: userhandling.php");
        exit();
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>

    <!-- Standard navbar -->



    <!--Form for users to input their information-->

    <div class="login">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <p><?= $error; ?></p>
            <br>
            <input type="text" placeholder="username" name="username">
            <br>
            <input type="password" placeholder="password" name="password">
            <br>
            <input type="submit" value="Register!">
        </form>
    </div>
</body>

</html>