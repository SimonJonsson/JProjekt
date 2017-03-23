<?php
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "jproj";

$servername = "textmine.se.mysql";
//$servername = "10.27.22.48";
$username = "textmine_se";
$password = "Y5NZ28CJ";
$dbname = "textmine_se";

// Create connection
//$conn = mysqli_connect($servername, $username, $password, $dbname);
$conn = mysqli_connect("textmine.se.mysql", "textmine_se", "Y5NZ28CJ", "textmine_se");

$conn->set_charset("utf8");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>