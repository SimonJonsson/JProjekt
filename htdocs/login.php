<?php
include 'header.php';

$code = $_POST['code'];

// If no code has been submitted -> login is false
if(empty($code)) {
    $login = False; 
} else {
    $login = checkLogin($code, $conn);
    // If code is in DB -> login is true
}

// If we cannot login -> display login form
// If we can login -> set cookies and redirect to index.php
if($login == False) {
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
        // Set one month expiry date
        setcookie("jproj_code", $code, time() + (60 * 60 * 24 * 365 * 10));
    }

    // Redirects to index.php
    $dir = dirname($file);
    $loc = 'Location: ' . $dir . '/index.php';
    header($loc);
}
include 'footer.php';
?>