<?php

// Used to verify userlogin
// Confirms that the user is in db
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
    $sql = "SELECT * FROM persianwords p
            LEFT JOIN words w ON w.wordid = p.id
            WHERE w.code <> '" . $code . "'
            ORDER BY rand() LIMIT 10";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row["word"] == "") { // There are no words left to input
        return False;
    } else {
        return $row["word"];
    }
}

// If we want to retrieve words not input by one user
function getRandomWordNotBy($conn, $byUser, $code) {
    // Retrieves all persian words not inputted by $byUser and the user $code
    $sql = 'SELECT * 
            FROM persianwords p 
            WHERE p.id NOT IN 
                 (SELECT wordid
                  FROM words w
                  WHERE (w.code = "' . $byUser . '" OR w.code = "' . $code . '"))
            ORDER BY rand() LIMIT 10';
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row["word"] == "") {
        return False;
    } else {
        return $row["word"];
    }
}

// If we want to retrieve words only inputted by one user
function getRandomWordInputtedBy($conn, $byUser, $code) {
    $sql = "SELECT * FROM persianwords p
            INNER JOIN words w 
            ON w.wordid = p.id
            WHERE w.code = '" . $byUser . "' 
            ORDER BY rand() LIMIT 10";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row["word"] == "") {
        return False;
    } else {
        return $row["word"];
    }
}

function getRandomWordBySource($conn, $source , $code) {
    $sql = 'SELECT * 
        FROM persianwords p 
        WHERE p.id NOT IN 
        (SELECT wordid
         FROM words w
         WHERE w.code = "' . $code . '")
        AND p.source = "' . $source . '"
        ORDER BY rand() LIMIT 10';
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row["word"] == "") {
        return False;
    } else {
        return $row["word"];
    }
}

// Get ID of persian word
function getWordId($conn, $word) {
    $sql = "SELECT * FROM persianwords WHERE word='" . $word . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row["id"] == "") {
        return False;
    } else {
        return $row["id"];
    }
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

// Removes user
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