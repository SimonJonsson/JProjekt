<?php

$code = $_POST['code'];

// If no code has been submitted -> login is false
if(empty($code)) {
    $login = False; 
} else {
    ob_start();
    include 'conn.php';
    include 'functions.php';
    $login = checkLogin($code, $conn);
    // If code is in DB -> login is true
}

// If the cookie is set -> login using cookie
if(isset($_COOKIE["jproj_code"])) {
    $login = checkLogin($_COOKIE["jproj_code"], $conn);
}

// If we cannot login -> display login form
// If we can login -> set cookies and redirect to index.php
if($login == False) {

    echo '<!DOCTYPE html>
    <html>
    <head>

    <title>Textmine</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

    </head>
    <body>';
    echo ' <div id="login">
<form method="post">
  Submit code';

    // If entered code is invalid, give error message
    if($login == False && !empty($code)) {
        echo '<p style="color: red;">Invalid code</p>';
    }

    echo '
  <input style="margin-top: 5px; margin-bottom: 5px;" type="text" name="code" maxlength="6"><br>
  <input type="submit" value="Submit">
</form>
</div>
';
} else {
    // If we have login enabled, but cookie is not set -> set cookie
    if(!isset($_COOKIE["jproj_code"])) {
        // Set ten years expiry date
        setcookie("jproj_code", $code, time() + (60 * 60 * 24 * 365 * 10));
    }

    // Redirects to index.php
    $loc = 'Location: /index.php';
    header($loc);
    ob_flush();
    ob_end_clean();
}
?>
