<?php
include 'header.php';

// If we don't have privilege 1, something is amiss, since it shouldn't be visible
if(getPrivilege($_COOKIE["jproj_code"], $conn) != 1) exit();

echo '<div class="main">';

echo 'Admin sida';

echo '</div>';
include 'footer.php'; 
?>