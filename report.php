<?php
echo 'hej';

if (isset($_POST["amount"])) {
    $amount = $_POST["amount"];
} else {
    $amount = 0;
}
?>