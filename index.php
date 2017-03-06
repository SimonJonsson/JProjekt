<?php
include 'header.php';

// Fetches random persian word, later used in comparison with dabire word
echo '<div id="wordMain" class="main">';

include 'footer.php';
?>

<script type="text/javascript">

 $(document).ready(function() {

     $("#wordMain").ready(function() {
         loadPage('words','#wordMain');
     });
 });


</script>
