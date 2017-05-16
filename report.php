<?php
include 'conn.php';
include 'functions.php';

if (!isset($_POST["create"])) {
    echo '<button id="createButton" type="button">Create report</button>';
} else {
    echo "Report written: \"report.rkt\" on server";
}

if (isset($_POST["create"])) {
    $sql = "SELECT * FROM words
    LEFT JOIN persianwords ON persianwords.id = words.wordid
    ORDER BY words.wordid ASC";
    $result = mysqli_query($conn, $sql);

    $pword = "";
    $report = fopen("report.rkt", "w") or die("Unable to open file");

    // ( (pword (list (CODE PRIVILEGE) DABIRE)))
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row["word"] != "") {
            if ($pword == "") {
                $pword = $row["word"];
                fwrite($report, "(\"" . $pword . "\" ");
            }

            if ($pword != $row["word"]) {
                $pword = $row["word"];
                fwrite($report, ") \n(\"" . $pword . "\" ");
            }
            fwrite($report, " (\"" . $row["code"] . "\" \"" . $row["dabire"] . "\")");
        }
    }
    fwrite($report, "))");
    fclose($report);
}
?>
<script type="text/javascript">
 $("#createButton").click(function(e) {
     $("#adminMain").load('report.php', {create: "True"});
 });
</script>
