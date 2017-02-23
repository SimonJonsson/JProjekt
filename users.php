<?php
// The purpose of the file is to list all users and also a field where one can add a a users.

// If page is loaded via jQuery we must include 'conn.php'; because of scope
include 'conn.php'; 

$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {

echo '<table>';
while ($row = mysqli_fetch_assoc($result)) {

echo '<tr>';
echo '<th>' . $row["id"] . '</th>';
echo '<th>' . $row["code"] . '</th>';
echo '<th>' . $row["privilege"] . '</th>';
echo '</tr>';
}
echo '</table>';
}
?>