<?php
setcookie("jproj_code", $code, time() - 10);
header('Location: /login.php');
?>