<?php
include 'conn.php';
include 'functions.php';

if(isset($_POST["words"])){
    $count = 0;
    foreach($_POST["words"] as $row) {
        if(getWordId($conn, $row) == False) {

            $sql = "INSERT INTO persianwords (word,tag,source)
                    VALUES ('" . $row ."','undef','crawler" . $_POST["pushv"] . "')";
            mysqli_query($conn, $sql);
        } else {
            $count = $count + 1;
        }
    }
    echo "False words: " . $count;
    $conn->close();
    exit();
}

if(isset($_POST["pushno"])) {
    $sql = "INSERT INTO pushes (pushno, date)
            VALUES (". $_POST["pushno"] .", CURDATE())";
    mysqli_query($conn, $sql);
    echo "Pushed: " . $_POST["pushno"];
} else {
    echo $_POST["pushno"];
}

$conn->close();
?>