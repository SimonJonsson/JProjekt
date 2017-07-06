<?php
include 'header.php';

// If we don't have privilege 1, something is amiss, since it shouldn't be visible
if(getPrivilege($_COOKIE["jproj_code"], $conn) != 1) exit();

echo '
<div id="submenu">
<ul class="topnav" id="myTopnav">
  <li><a href="javascript:void(0);" id="usrBtn">Users</a></li>
  <li><a href="javascript:void(0);" id="repBtn">Report</a></li>
  <li><a href="javascript:void(0);" id="updateBtn">Update</a></li>
</ul>
</div>';

// Just a placeholder div for jQuery to load onto.
echo '<div id="adminMain" class="main">';
echo '</div>';

include 'footer.php'; 
?>
<script type="text/javascript" >
 $(document).ready(function() {
     // Load user page when site is loaded fully
     $("#adminMain").ready(function() {
         loadPage('users','#adminMain');
     });

         // Makes buttonclicks jQuery -> no ugly urls
     $("#usrBtn").click(function() {
         loadPage('users','#adminMain');
     });

     $("#repBtn").click(function() {
         loadPage('report','#adminMain');
     });

     $("#updateBtn").click(function() {
         loadPage('update','#adminMain');
     });
 });

</script>
