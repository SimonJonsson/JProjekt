<?php

include 'functions.php';
include 'conn.php';


$persWord = getRandomWord($conn);
//$persWord = getRandomWordUnique($conn, $_COOKIE["jproj_code"]);
echo '<form id="wordform">';
echo '<p id="arWord">' . $persWord . '</p>';
echo '<input type="hidden" name="wordId" value="' . $persWord . '" />';
echo '<input id="dabInput" type="text" name="dabire" maxlength="30" /><br>';
//echo '<input type="submit" value="Submit" />';
echo '</form>';
echo '</div>';

if (isset($_POST["dabire"]) && isset($_POST["wordId"])) {
    $sql = 'INSERT INTO words (wordid, dabire, code)
VALUES (' . getWordId($conn, $_POST["wordId"]) .
         ', "' . $_POST["dabire"] . '"' .
         ', "' . $_COOKIE["jproj_code"] . '")';
    mysqli_query($conn, $sql);
}

?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#dabInput").focus();

        $("#wordform").keypress(function(e) {
            if (e.which == 13) {
                e.preventDefault();
                word = $("#dabInput").val();
                id = $("input[name='wordId']").val();
                if (word != "") {
                    $("#wordMain").load('words.php', {dabire: word, wordId: id});
                }
            }
        });
    })
    </script>