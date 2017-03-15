<?php
include 'conn.php';
include 'functions.php';


if (isset($_POST["amount"])) {
    $amount = $_POST["amount"];
} else {
    $amount = 0;
}

$sql = "SELECT * FROM words w, persianwords p WHERE w.wordid = p.id";
$result = mysqli_query($conn, $sql);

echo '<table>';
echo '<tr>';
echo '<th>P.Arabic</th>';
echo '<th>Dabire</th>';
echo '</tr>';

while($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<th>' . $row["word"] . '</th>';
    echo '<th>' . $row["dabire"] . '</th>';
    echo '</tr>';
}

echo '</table>';
?>