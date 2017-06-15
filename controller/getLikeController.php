<?php
defined('INDEX') or exit("Access denied! Request from an external source");
ini_set('memory_limit', '512M');



$options = json_decode(html_entity_decode(isset($_REQUEST['options']) ? $_REQUEST['options'] : null), true);
if($options == null){
	die("No options inputed");
}
// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
// }
$_SESSION["userid"] = $options["user_id"];
$postid = (isset($options["post_id"])) ? $options["post_id"] : null;

$model = new Instucom("likes");
$data = $model->get_model()->get_likes($postid);
        if($data != 'error'){
            echo json_encode(['status' => 'success', 'data' => $data]);
        }
        else echo json_encode(['status' => 'error', 'data' => '']);
        die();






?>