<?php
include 'conn.php';
include 'functions.php';
//header("Access-Control-Allow-Origin: http://dabirescript.appspot.com/getlatestpushno");

//header("Access-Control-Allow-Origin: http://dabirescript.appspot.com");
$sql = "SELECT * FROM pushes ORDER BY pushno desc";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if ($row["pushno"] == "") {
    $pushno = 0;
} else {
    $pushno = $row["pushno"];
}

echo '<table>
      <tr><td>Latest push version</td><td id="pushv">0</td></tr>
      <tr><td>Our push version</td><td id="pushvdb">' . $pushno . '</td></td>
      </table>
';
echo '<br><a href="javascript:void(0);" id="downloadBtn">Download latest push</a>';
echo '<br><p id="loadDummy" />'


?>

<script type="text/javascript">

    $(document).ready(function() {
        $("#downloadBtn").hide();
        var pushurl = "http://dabirescript.appspot.com/getlatestpushno";
        var pushver = 0;
        var pushverdb = Number($("#pushvdb").text());

        $.getJSON(pushurl, function(result) {
            pushver = result.num;
            //console.log(pushver);
            $("#pushv").text(result.num);
            
            if(pushver > pushverdb) {
                $("#downloadBtn").show();
            }
        });

        $("#downloadBtn").click(function() {
            $("#downloadBtn").hide();
            var getURL = "http://dabirescript.appspot.com/getwords/push/";
            var getPush = pushverdb + 1;
            getURL = getURL + getPush;
            $("#loadDummy").text("Loading data...");

            $.getJSON(getURL, function(result) {
                // Since we can only send a chunk of 1000 at a time, we have to divide the payload
                var arr = result.words;
                var totalchunks = Math.ceil(arr.length/1000);
                var done = 0;
                $("#loadDummy").text("Processing data... (Done: 0/" + totalchunks + ")");

                for (chunk = 1; chunk <= totalchunks; chunk++) {
                    wordChunk = arr.slice(1000*(chunk-1),1000*chunk);
                    $.ajax({
                     type: "POST",
                     url: "updateHandle.php",
                     //async: false,
                     data: {words: wordChunk, pushv: getPush},
                     success: function() {
                         console.log('Items added, push: ' + getPush);
                         done = done + 1;
                         $("#loadDummy").text("Processing data... (Done: " + done + "/" + totalchunks + ")");

                         if (done == totalchunks) {
                             $.ajax({
                              type: "POST",
                              url: "updateHandle.php",
                              data: {pushno: getPush},
                              success: function() {
                                  console.log("Added pushes");
                                  $("#loadDummy").text("Done");
                                  $("#pushvdb").text(getPush);
                              }
                              });
                         }
                     },
                     error: function(e) {
                         console.log('Errors happened ' + e.message);
                     }
                     });
                }
            });
        });
    });
</script>
