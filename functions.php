<?php

// used to verify userlogin
function checkLogin($code, $conn) {
    $login = False;
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            if($row["code"] == $code) {
                $privilege = $row["privilege"];
                $login = True;
                break;
            }
        }
    }
    return $login;
}

function getPrivilege($code, $conn) {
    $sql = "SELECT privilege FROM users WHERE code='" . $code . "'";
    $result = mysqli_query($conn, $sql);
    $priv = mysqli_fetch_assoc($result);
    return $priv["privilege"];
}

// Fetches random persoarabic word
function getRandomWord($conn) {
    $sql = "SELECT * FROM persianwords ORDER BY rand() LIMIT 10";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row["word"];
}

// Get ID of persian word
function getWordId($conn, $word) {
    $sql = "SELECT id FROM persianwords WHERE word='" . $word . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row["id"];
}
?>

<script type="text/javascript">

// Easy function to dynamically load page. Will make things neater.
function loadPage(page, target) {
    $(target).load(page + ".php");
}

</script>