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

// Fetches user privileges
function getPrivilege($code, $conn) {
    $sql = "SELECT privilege FROM users WHERE code='" . $code . "'";
    $result = mysqli_query($conn, $sql);
    $priv = mysqli_fetch_assoc($result);
    return $priv["privilege"];
}

// Fetches random perso-arabic word
function getRandomWord($conn) {
    $sql = "SELECT * FROM persianwords ORDER BY rand() LIMIT 10";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row["word"];
}

// Fetches a perso-arabic word, unique for the user
function getRandomWordUnique($conn, $code) {
    $sql = "SELECT * FROM words WHERE code = '" . $code . "'";
    $result = mysqli_query($conn, $sql);

    // If we have already entered some words, find unique ones
    // else we should just find a random word
    if (mysqli_num_rows($result) > 0) {
        // A very sub-optimal solution, proper SQL query should be made sooner or later
        $sqlW = "SELECT * FROM persianwords WHERE id NOT IN (";
        // Appends used id's in a list which we exempt in the sql query
        while($row = mysqli_fetch_assoc($result)) {
            $sqlW = $sqlW . $row["wordid"] . ",";
        }

        //substr prunes residual commas
        $sqlW = substr($sqlW, 0, -1) . ") ORDER BY rand() LIMIT 10";
        $resultW = mysqli_query($conn, $sqlW);
        $row = mysqli_fetch_assoc($resultW);
        if ($row["word"] == "") { // There are no words left to input
            return False;
        } else {
            return $row["word"];
        }
    } else {
        return getRandomWord($conn);
    }
}

// If we want to retrieve words only inputted by one user
function getRandomWordInputtedBy($conn, $byUser, $code) {
    $sql = "SELECT * FROM words WHERE code = '" . $code . "'";
    $result = mysqli_query($conn, $sql);

    // If it's not the users first time to input a word, else give random word
    if (mysqli_num_rows($result) > 0) {
        $sqlW = "SELECT * FROM words w
        INNER JOIN persianwords pw 
        ON w.wordid = pw.id
        WHERE w.code = '" . $byUser . "'
        AND pw.id NOT IN (";
        while($row = mysqli_fetch_assoc($result)) {
            $sqlW = $sqlW . $row["wordid"] . ",";
        }

        // substr prunes residual commas
        $sqlW = substr($sqlW, 0, -1) . ") ORDER BY rand() LIMIT 10";
        $resultW = mysqli_query($conn, $sqlW);
        $row = mysqli_fetch_assoc($resultW);
        if ($row["word"] == "") {
            return False;
        } else {
            return $row["word"];
        }
    } else {
        $sqlW = "SELECT * FROM words w
        INNER JOIN persianwords pw 
        ON w.wordid = pw.id
        WHERE w.code = '" . $byUser . "'
        ORDER BY rand() LIMIT 10";
        $resultW = mysqli_query($conn, $sqlW);
        $row = mysqli_fetch_assoc($resultW);

        return $row["word"];
    }
}

// Get ID of persian word
function getWordId($conn, $word) {
    $sql = "SELECT * FROM persianwords WHERE word='" . $word . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row["id"];
}

// Adds a user with a code and privilege, also checks if code isn't taken
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