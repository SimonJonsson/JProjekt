<!DOCTYPE html>
<html>
<head>

<title>Textmine</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
      <meta charset="UTF-8">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

</head>
<body>
<?php
include 'conn.php';
include 'functions.php';
header("Content-Type: text/html;charset=UTF-8");

// If the login-cookie is not set, redirect to login page
// If cookie is set and user does not exist, kick user
// else display the menu
if(!isset($_COOKIE["jproj_code"])) {
    $file = $_SERVER["SCRIPT_NAME"];
    $dir = dirname($file);
    $redir = $dir . '/login.php';

    if($file != $redir){
        $loc = 'Location: ' . $dir . '/login.php';
        header($loc);
    } 
    //exit();
} elseif(isset($_COOKIE["jproj_code"]) && checkLogin($_COOKIE["jproj_code"], $conn) == False) {
    setcookie("jproj_code", "", time()-3600);
    echo 'user does not exist';
}else {
    // Outputs the top menu
    echo '
<div id="menu">
<ul class="topnav" id="myTopnav">
  <li><a href="index.php">Words</a></li>
  <li><a href="about.php">About</a></li>';
        // If we have admin privileges, show tab
if(getPrivilege($_COOKIE["jproj_code"], $conn) == 1) {
    echo '<li><a class="adminbtn" href="admin.php">Admin</a></li>';
}

echo '
</ul>
</div>
';

}
?>