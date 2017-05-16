<?php
include 'functions.php';
include 'conn.php';

// If we want to submit, confirm all variables are set then enter into DB
if ($_POST["submit"] == "True" && isset($_POST["dabire"]) && isset($_POST["pword"])) {
    $sql = 'INSERT INTO words (wordid, dabire, code)
VALUES (' . getWordId($conn, $_POST["pword"]) .
         ', "' . $_POST["dabire"] . '"' .
         ', "' . $_COOKIE["jproj_code"] . '")';
    mysqli_query($conn, $sql);
}
$code = $_COOKIE["jrpoj_code"];
// If "confirm" is True then we have POSTed a word and wait for confirmation
if ($_POST["redo"] == "True" || $_POST["confirm"] == "True") {
    $persWord = $_POST["pword"];
} elseif (/*$code == "JALALM" || */$code == "F4AFAD") { // Jalal and F4AFAD gets new unique words
    $persWord = getRandomWordUnique($conn, $code);
} else {
    $persWord = getRandomWordInputtedBy($conn, "F4AFAD", $code);
}

// Means that there are no more words
if ($persWord == False) {
    echo '<p>No words left</p>';
} else {
    echo '<form id="wordForm">';
    echo '<p id="arWord">' . $persWord . '</p>';
    echo '<input type="hidden" name="pword" value="' . $persWord . '" />';

    // For control purposes we want to give the user a chance to redo the word or confirm
    // if $_POST["submit"] == "True" then store the word and output new word (not done here)
    if ($_POST["confirm"] == "True") {
        echo '<div>';
        echo $_POST["dabire"];
        echo '<input id="dabInput" type="hidden" name="dabire" value="' . $_POST["dabire"] . '" />';
        echo '<br>';
        echo '<a id="confirmButton" href="javascript:void(0);"><img src="img/add.png" alt="Confirm" height="20" width="20" /></a> ';
        echo '<a id="redoButton" href="javascript:void(0);"><img src="img/edit.png" alt="Edit" height="20" width="20" /></a>';
        echo '</div>';
    } else {
        if ($_POST["redo"] == "True") {
            echo '<input id="dabInput" type="text" name="dabire" maxlength="40" value= "' . $_POST["dabire"] . '"/><br>';
        } else {
            echo '<input id="dabInput" type="text" name="dabire" maxlength="40" /><br>';
        }
    }
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
         if (e.which == 13) { // Enter = 13th key
             e.preventDefault();
             word = $("#dabInput").val();
             id = $("input[name='pword']").val();
             if (word != "") {
                 $("#wordMain").load('words.php', {dabire: word, pword: id, confirm: "True"});
             }
         }
     });

     // If we confirm the word then load page without POST data
     $("#confirmButton").click(function(e) {
         e.preventDefault();
         word = $("#dabInput").val();
         id = $("input[name='pword']").val();

         $("#wordMain").load('words.php', {dabire: word, pword: id, submit: "True"});
     });

     // If we want to redo, reload page with POST data
     $("#redoButton").click(function(e) {
         e.preventDefault();
         confirm = $("input[name='confirm']").val();
         word = $("#dabInput").val();
         id = $("input[name='pword']").val();

         $("#wordMain").load('words.php', {dabire: word, pword: id, redo: "True"});
     });
 });
</script>
