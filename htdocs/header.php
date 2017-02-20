<!DOCTYPE html>
<html>
<head>

<title>TEST</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />

</head>
<body>
<?php
if(!isset($_COOKIE["jproj_code"])) {
    $file = $_SERVER["SCRIPT_NAME"];
    $dir = dirname($file);
    $redir = $dir . '/login.php';

    if($file != $redir){
        $loc = 'Location: ' . $dir . '/login.php';
        header($loc);
    } 
    //exit();
} else {
    echo "
    <div id='menu'>
    <ul>
    <li><a href='#home'>Home</a></li>
    <li><a href='#news'>News</a></li>
    <li><a href='#contact'>Contact</a></li>
    <li><a href='#about'>About</a></li>
    </ul>
    </div>
";
}
?>