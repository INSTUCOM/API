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
$student_course = (isset($options["student_course"])) ? $options["student_course"] : null;
$point = (isset($options["point"])) ? $options["point"] : null;
if(sizeof($student_course) != sizeof($point)) die("mismatch");
$data = array();
for($i = 0; $i < sizeof($student_course); $i++){
    $data[$i]['student_course'] = $student_course[$i];
    $data[$i]['point'] = $point[$i];
    $data[$i]['created'] = date('Y-m-d H:i:s');
}

$model = new Instucom("grade");
if($model->get_model()->store_grades($data)){
    echo "success";
}
else echo "error";
die();



?>