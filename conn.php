<?php

$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "jproj";


/*
$servername = "textmine.se.mysql";
$username = "textmine_se";
$password = "Y5NZ28CJ";
$dbname = "textmine_se";
*/

// Create connection
$maintenance = False;
if (!$maintenance) {
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $conn->set_charset("utf8");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
} else {
    echo "Maintenance. Reload page.";
    exit();
}
?>