<?php
$token = isset($_GET['public_token']) ? $_GET['public_token']: null;
ini_set('memory_limit', '512M');
if($token == null){
    die('Acsess denied! Provide a token for your request');
}
date_default_timezone_set("Africa/Lagos");
header("Access-Control-Allow-Origin:*");
define('INDEX', dirname(__FILE__) . '/');
include("controller/urlController.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$uri = $_SERVER['REQUEST_URI'];
$url = new URL($uri);
$url->get_page();
$url->render();
?>
