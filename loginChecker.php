<?php

// If the login-cookie is not set, redirect to login page
// If cookie is set and user does not exist, kick user
// else display the menu
if(!isset($_COOKIE["jproj_code"])) {
    /*
    $file = $_SERVER["SCRIPT_NAME"];
    $dir = dirname($file);
    $redir = $dir . '/login.php';

    // Get HTTP/HTTPS (the possible values for this vary from server to server)
    $myUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] && !in_array(strtolower($_SERVER['HTTPS']),array('off','no'))) ? 'https' : 'http';
    // Get domain portion
    $myUrl .= '://'.$_SERVER['HTTP_HOST'];
    // Get path to script
    $myUrl .= $_SERVER['REQUEST_URI'];
    // Add path info, if any
    if (!empty($_SERVER['PATH_INFO'])) $myUrl .= $_SERVER['PATH_INFO'];
    // Add query string, if any (some servers include a ?, some don't)
    if (!empty($_SERVER['QUERY_STRING'])) $myUrl .= '?'.ltrim($_SERVER['REQUEST_URI'],'?');
    */
    $loc = 'Location: /login.php';
    header($loc);
    //exit();
} elseif(isset($_COOKIE["jproj_code"]) && checkLogin($_COOKIE["jproj_code"], $conn) == False) {
    setcookie("jproj_code", "", time()-3600);
    $loc = 'Location: /login.php';
    header($loc);
}
?>