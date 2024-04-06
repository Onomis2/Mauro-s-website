<?php

session_start();
//Establishes connection to the database with name maurowebsite
    
$dsn = 'mysql:host=localhost;dbname=maurowebsite';
$username = 'bit_academy';
$password = 'bit_academy';

$dbh = new PDO($dsn, $username, $password);
