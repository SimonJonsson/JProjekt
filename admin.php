<?php
include 'header.php';

// If we don't have privilege 1, something is amiss, since it shouldn't be visible
if(getPrivilege($_COOKIE["jproj_code"], $conn) != 1) exit();

echo '<div id="adminMain" class="main">';

echo 'Admin sida';
// Möjlighet att skriva ut en rapport. Där man kan välja TAG och kolonner. Format CSV
// Lägga till användare
// Ta bort användare

echo '</div>';
include 'footer.php'; 
?>