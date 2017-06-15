<?php
defined('INDEX') or exit("Access denied! Request from an external source");
ini_set('memory_limit', '512M');



$options = json_decode(html_entity_decode(isset($_GET['options']) ? $_GET['options'] : null), true);
if($options == null){
	die("No options inputed");
}
// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
// }
$_SESSION["userid"] = $options["user_id"];
$semester = (isset($options["semester"])) ? $options["semester"] : null;
$level = (isset($options["level"])) ? $options["level"] : null;

$model = new Instucom("");
$data = $model->get_model()->get_grades($semester,$level);
if($data != 'error'){
    echo json_encode(['status' => 'success', 'data' => $data]);
}
else echo json_encode(['status' => 'error', 'data' => '']);
die();



?>