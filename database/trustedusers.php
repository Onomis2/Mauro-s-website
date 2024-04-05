<?php

//Connects to database and creates the TrustedUsers array

$db = mysqli_connect("localhost", "bit_academy", "bit_academy", "maurowebsite");
$trustedUsers = array();

//Retrieves all admins from the database

$query = $dbh->prepare("SELECT username, admin FROM users WHERE admin = 'YES'");
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);

//Puts all of the admins into the array

if ($result) {
    foreach ($result as $row) {
        $trustedUsers[] = $row['username'];
    }
}
