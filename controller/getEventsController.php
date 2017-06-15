<?php
defined('INDEX') or exit("Access denied! Request from an external source");
$userid = isset($_POST['user_id']) ? $_POST['user_id'] : null;

if($userid == null) die("no user");

$newEvent = new Instucom("events");
die($newEvent->get_model()->get_events($userid));

?>