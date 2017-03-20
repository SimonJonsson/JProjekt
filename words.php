<?php

include 'functions.php';
include 'conn.php';

$persWord = getRandomWordUnique($conn, $_COOKIE["jproj_code"]);

echo '<form id="wordForm">';
echo '<p id="arWord">' . $persWord . '</p>';
echo '<input type="hidden" name="pword" value="' . $persWord . '" />';
echo '<input id="dabInput" type="text" name="dabire" maxlength="30" /><br>';
//echo '<input type="submit" value="Submit" />';
echo '</form>';
echo '</div>';

if (isset($_POST["dabire"]) && isset($_POST["pword"])) {
    $sql = 'INSERT INTO words (wordid, dabire, code)
VALUES (' . getWordId($conn, $_POST["pword"]) .
         ', "' . $_POST["dabire"] . '"' .
         ', "' . $_COOKIE["jproj_code"] . '")';
    mysqli_query($conn, $sql);
}
?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#dabInput").focus();

            $("#wordForm").keypress(function(e) {
                if (e.which == 13) {
                    e.preventDefault();
                    word = $("#dabInput").val();
                    id = $("input[name='pword']").val();
                    if (word != "") {
                        $("#wordMain").load('words.php', {dabire: word, pword: id});
                    }
                }
            });
    });
</script>