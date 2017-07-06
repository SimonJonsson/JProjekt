<?php
include 'conn.php';
include 'functions.php';

if(isset($_POST["words"])){
    foreach($_POST["words"] as $row) {
        if(getWordId($conn, $row) == False) {
            $count = $count + 1;

            $sql = "INSERT INTO persianwords (word,tag,source)
                    VALUES ('" . $row ."','undef','crawler" . $_POST["pushv"] . "')";
            mysqli_query($conn, $sql);
        }
    }
    //echo "words: " . $count;
}
if(isset($_POST["pushno"])) {
    $sql = "INSERT INTO pushes (pushno, date)
            VALUES (". $_POST["pushno"] .", CURDATE())";
    mysqli_query($conn, $sql);
    //echo "Pushed: " . $_POST["pushno"];
}
$conn->close();
?>