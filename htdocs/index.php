<?php
include 'header.php';

// Fetches random persian word, later used in comparison with dabire word
$persWord = getRandomWord($conn);
echo '<div class="main">';
echo '<form method="post">';
echo $persWord;
echo '<input type="hidden" name="pers" value="' . $persWord . '" />';
echo '<input type="text" name="dabire" maxlength="40" />';
echo '<input type="submit" value="Submit" />';
echo '</form>';
echo '</div>';

$sql = 'INSERT INTO words (wordid, dabire, code)
VALUES (' . getWordId($conn, $_POST["pers"]) .
     ', "' . $_POST["dabire"] . '"' .
     ', "' . $_COOKIE["jproj_code"] . '")';
mysqli_query($conn, $sql);

include 'footer.php';
?>
