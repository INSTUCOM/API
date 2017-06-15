<?php
defined('INDEX') or exit("Access denied! Request from an external source");
ini_set('memory_limit', '512M');



$options = json_decode(html_entity_decode(isset($_REQUEST['options']) ? $_REQUEST['options'] : null), true);
if($options == null){
	die("No options inputed");
}
if (session_status() == PHP_SESSION_NONE) {
    @session_start();
}
$_SESSION["userid"] = $options["user_id"];
$postid = (isset($options["post_id"])) ? $options["post_id"] : null;

$model = new Instucom("comments");
$data = $model->get_model()->get_comments($postid);
for($i = 0; $i < sizeof($data); $i++){    
$content= stripslashes (htmlspecialchars ($data[$i]['comment']));
$data[$i]['comment'] = (! get_magic_quotes_gpc ()) ? html_entity_decode(addslashes ($content)) : html_entity_decode($content);
}
        if($data != 'error'){
            echo json_encode(['status' => 'success', 'data' => $data]);
        }
        else echo json_encode(['status' => 'error', 'data' => '']);
        die();






?>