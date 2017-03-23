<?php
include 'functions.php';
include 'conn.php';

if (isset($_POST["dabire"]) && isset($_POST["pword"])) {
    $sql = 'INSERT INTO words (wordid, dabire, code)
VALUES (' . getWordId($conn, $_POST["pword"]) .
         ', "' . $_POST["dabire"] . '"' .
         ', "' . $_COOKIE["jproj_code"] . '")';
    mysqli_query($conn, $sql);
}

$persWord = getRandomWordUnique($conn, $_COOKIE["jproj_code"]);

if ($persWord == False) {
    echo '<p>No words left</p>';
} else {
    echo '<form id="wordForm">';
    echo '<p id="arWord">' . $persWord . '</p>';
    echo '<input type="hidden" name="pword" value="' . $persWord . '" />';
    echo '<input id="dabInput" type="text" name="dabire" maxlength="30" /><br>';
    echo '</form>';
}
//echo '<input type="submit" value="Submit" />';
echo '</div>';

?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#dabInput").focus();

            // If we press enter while form is focused, we want to intercept
            // and post using jQuery
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