<?php
$maintenance = False;
if ($maintenance) {
    header('Location: /maintenance.php');
} else {
    ob_start();
    include 'conn.php';
    include 'functions.php';
    include 'loginChecker.php';
    ob_flush();
    ob_end_clean();
}
?>
<!DOCTYPE html>
<html>
<head>

<title>Textmine</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
      <meta charset="UTF-8">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

</head>
<body>
    <div id="menu">
    <ul class="topnav" id="myTopnav">
    <li><a href="index.php">Words</a></li>
    <li><a href="about.php">About</a></li>
    <?php
    // If we have admin privileges, show tab
    if(getPrivilege($_COOKIE["jproj_code"], $conn) == 1) {
        echo '<li><a class="adminbtn" href="admin.php">Admin</a></li>';
    }
    echo '<li style="float:right"><a href="logout.php">Logout</a></li>';
    // A bit ugly but does the work
    echo '<li style="float:right;display:inline-block;font-size:17px;padding: 14px 16px;">' . $_COOKIE["jproj_code"] . '</li>';
    ?>
</ul>
</div>



