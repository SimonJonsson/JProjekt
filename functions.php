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

function getRandomWordUnique($conn, $code) {
    $sql = "SELECT * FROM persianwords p, words w WHERE NOT w.wordid = p.id AND w.code =\"" . $code . "\"";
    $hej = "SELECT * FROM persianwords p LEFT JOIN words w ON p.id = w.wordid AND NOT w.code = 'SIMONJ' WHERE w.wordid IS NULL";
    echo $sql;
}

// Get ID of persian word
function getWordId($conn, $word) {
    $sql = "SELECT id FROM persianwords WHERE word='" . $word . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row["id"];
}

//
function addUser($conn, $code, $privilege) {
    // If the query returns a value, the user exists
    $sql = 'SELECT code FROM users WHERE code="' . $code;
    $result = mysqli_query($conn, $sql);
    //$rows = mysqli_num_rows($result);
    if (!empty($result)) { return False; }

    $sql = 'INSERT INTO users (code, privilege)
VALUES ("' . $code . '", ' . $privilege . ')';
    mysqli_query($conn, $sql);
    return True;
}

function removeUser($conn, $userId) {
    $sql = 'DELETE FROM users WHERE id=' . $userId;
    $result = mysqli_query($conn, $sql);
    return True;
}
?>

<script type="text/javascript">

    // Generates 6 digit HEX number, which is used as a user code
    function generateCode() {
        code = Math.ceil(Math.random() * (16777215 - 1048575) + 1048576);
        code = (code.toString(16)).toUpperCase();
        return code;
    }

// Easy function to dynamically load page. Will make things neater.
function loadPage(page, target) {
    $(target).load(page + ".php");
}

</script>