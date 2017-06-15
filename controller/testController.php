<?php
defined('INDEX') or exit("Access denied! Request from an external source");
ini_set('memory_limit', '512M');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['userid'] = 1;

$newEvent = new Instucom("events");
//$newEvent->get_model()->update_fields(["event"=>'f',"modified"=>'created'],["userid"=>'1',"usrid"=>'1',"serid"=>'1']);
$next = date('Y') + 1;
echo date($next.'-m-d H:i:s');
die();


?>