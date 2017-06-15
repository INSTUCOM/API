<?php
defined('INDEX') or exit("Request from an external source");
ini_set('memory_limit', '512M');
$options = json_decode(html_entity_decode(isset($_GET['options']) ? $_GET['options'] : null), true);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$_SESSION["userid"] = $options["user_id"];
$post_id = $options["post_id"];

$data = new Instucom("likes");


$news = $data->like_post($post_id);

//$data = new Instucom("news");
//$news = $data->get_news($post_id);


?>