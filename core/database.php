<?php

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$database = "wiscoprimenl";

$GLOBALS['path'] = "/wiscoprimenl/";

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on" ? "https://" : "http://";
$GLOBALS['ROOT'] = $protocol.$_SERVER['HTTP_HOST']."/";

// add api keys here