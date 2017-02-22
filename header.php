<!DOCTYPE html>
<html>
<head>

<title>TEST</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
      <meta charset="UTF-8">

</head>
<body>
<?php
include 'conn.php';
include 'functions.php';
header("Content-Type: text/html;charset=UTF-8");

// If the login-cookie is not set, redirect to login page
if(!isset($_COOKIE["jproj_code"])) {
    $file = $_SERVER["SCRIPT_NAME"];
    $dir = dirname($file);
    $redir = $dir . '/login.php';

    if($file != $redir){
        $loc = 'Location: ' . $dir . '/login.php';
        header($loc);
    } 
    //exit();
} else {

    $code = $_COOKIE["jproj_code"];

    echo '
<div id="menu">
<ul class="topnav" id="myTopnav">
  <li><a href="index.php">Words</a></li>
  <li><a href="about.php">About</a></li>';

if(getPrivilege($code, $conn) == 1) {
    echo '<li><a class="adminbtn" href="admin.php">Admin</a></li>';
}

echo '
</ul>
</div>
';
}
?>