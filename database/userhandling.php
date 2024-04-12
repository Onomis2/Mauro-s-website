<?php

require_once 'connection.php';
session_start();
$wrong = false;

if (isset($_SESSION['username'])) {
    session_destroy();
    echo "Succesfully logged out.";
}

if (isset($_GET['message'])) {
    switch ($_GET['message']) {
        case '1':
            echo "You have been logged out because of a website update that requires a log-out.";
            break;
        
        case '2':
            echo "No user detected, please log in.";
            break;
        case '3':
            echo "Illegal action. You have been logged out.";
            break;
        default:
            echo 'Unknown error. You have been logged out automatically.';
            break;
    }
}

//Executes code if a post is detected

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Converts posts into regular variables

    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    //Checks wether the password is correct

    $stmt = $dbh->prepare("SELECT * FROM users WHERE username=:username ");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    //If password is correct session is sets to the user 
    //and the user is redirected to the home page
    //If password is incorrect throw error message

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['id'] = $user['id'];
        $_SESSION['admin'] = $user['admin'];
        header('Location: ../index.php');
        exit();
    } else {
        $wrong = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, length=device-length, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/content.css">
</head>

<body>

    <!--Standard navbar-->



    <!--Login submission form-->

    <div class="login">
        <h1>Log in</h1>
        <?php if ($wrong == true) : ?>
            <p class="error">Invalid username or password.</p>
        <?php endif; ?>
        <form method="post">
            <input type="text" placeholder="username" name="username">
            <br>
            <input type="password" placeholder="password" name="password">
            <p><input type="submit" value="Login"></p>
            <p><a href="register.php">Register</a></p>
        </form>
    </div>
</body>

</html>