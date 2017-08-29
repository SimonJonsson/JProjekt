<?php
// The purpose of the file is to list all users and also a field where one can add a a users.

// If page is loaded via jQuery we must include 'conn.php'; because of scope
include 'conn.php';
include 'functions.php';

// Add user form
echo '<form id="newinput">';
echo 'Code: <input name="code" maxlength="6" readonly />';
echo '<button id="genbtn">Generate</button><br>';
echo 'Privilege:
<select id="priv" name="privilege">
               <option value = "1">1</option>
               <option value = "2">2</option>
               <option value = "3">3</option>
               <option value = "4">4</option>
               <option selected="selected" value = "5">5</option>
             </select>
';
echo '<br><input id="submitter" name="submit" value="Add user" type="submit" />';
echo '</form>';

// If the POST data exists, then w want to add the user
if(isset($_POST["code"])) {
    $success = addUser($conn, $_POST["code"], $_POST["privilege"]);
    echo '<p>';
    if ($success) {
        echo 'User added';
    } else {
        echo 'Adding user failed';
    }
    echo '</p>';
}

// If the POST data exists, then we want to remove the user
if(isset($_POST["userId"])) {
    $success = removeUser($conn, $_POST["userId"]);
    echo '<p>';
    if ($success) {
        echo 'User removed';
    } else {
        echo 'Removing user failed';
    }
    echo '</p>';
}

// If no action is to be made, output a break, for aesthetic reasons
if (!isset($_POST["userId"]) && !isset($_POST["code"])) echo '<br>';

// This lists all users in DB.
$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    echo '<table>';
    echo '<tr>';
    echo '<th>id</th>';
    echo '<th>Code</th>';
    echo '<th>Privilege</th>';
    echo '<th>Count</th>';
    echo '<th>Remove</th>';
    echo '</tr>';

    // Fetches each user and puts it in table row
    while ($row = mysqli_fetch_assoc($result)) {
        $sqlC = "SELECT count(*) c FROM words WHERE code='" . $row["code"] . "'";
        $resultC = mysqli_query($conn, $sqlC);
        $wordcount = mysqli_fetch_assoc($resultC);
        echo '<tr>';
        echo '<th>' . $row["id"] . '</th>';
        echo '<th>' . $row["code"] . '</th>';
        echo '<th>' . $row["privilege"] . '</th>';
        echo '<th>' . $wordcount["c"] . '</th>';
        // Remove user button
        echo '<th><a class="removebtn" data-index="' . $row["id"] . '" href="javascript:void(0);" style="color:red; text-decoration:none;">X</a></th>';
        echo '</tr>';
    }
    echo '</table>';
}
?>
<script type="text/javascript">

 // If the form has loaded, generate a 6-digit HEX code
 $("#newinput").ready(function() {
     $("#genbtn").click(function(e) {
         e.preventDefault(); // So we don't submit form
         $("input[name='code']").val(generateCode());
     });

     // We need to submit user data using AJAX
     $("#submitter").click(function(e) {
         e.preventDefault();
         codeData = $("input[name='code']").val();
         privData = $("#priv").val();
         //data = 'code=' + code + '&privilege=' + priv + '&submit=Submit';
         $("#adminMain").load('users.php', {code: codeData, privilege: privData});
         //loadPageP('users','#adminMain',data);
     });

     $("input[name='code']").val(generateCode());

     $(".removebtn").click(function (e) {
         e.preventDefault();
         userId = $(this).data('index');
         $("#adminMain").load('users.php', {userId: userId});
     });
 });

</script>
