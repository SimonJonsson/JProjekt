<?php
include 'conn.php';
include 'functions.php';

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
            var geturl = "http://dabirescript.appspot.com/getwords/push/";
            var getpush = pushverdb + 1;
            geturl = geturl + getpush;
            $("#loadDummy").text("Loading data...");
            $.getJSON(geturl, function(result) {
                // Since we can only send a chunk of 1000 at a time, we have to divide the payload
                var arr = result.words;
                var totalchunks = Math.ceil(arr.length/1000);
                $("#loadDummy").text("Processing data...");

                done = 0;
                for (chunk = 1; chunk <= totalchunks; chunk++){
                    wordChunk = arr.slice(1000*(chunk-1),1000*chunk);
                    $.ajax({
                     type: "POST",
                     url: "updateHandle.php", 
                     data: {words: wordChunk, pushv: getpush},
                     success: function() {
                         console.log('Items added');
                         done++;
                         if (done == totalchunks) {
                             $.ajax({
                              type: "POST",
                              url: "updateHandle.php",
                              data: {pushno: getpush},
                              success: function() {
                                  $("#loadDummy").text("Done");
                                  $("#pushvdb").text(getpush);
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
