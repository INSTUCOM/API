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
$course_id = (isset($options["course_id"])) ? $options["course_id"] : null;
$active = (isset($options["active"])) ? $options["active"] : null;
$semester = (isset($options["semester"])) ? $options["semester"] : null;
$level_id = (isset($options["level_id"])) ? $options["level_id"] : null;
$data = array();
for($i = 0; $i < sizeof($course_id); $i++){
    $data[$i]['courseid'] = $course_id[$i];
    $data[$i]['active'] = $active[$i];
    $data[$i]['semester'] = $semester[$i];
    $data[$i]['levelid'] = $level_id[$i];
}

$model = new Instucom("user_courses");
if($model->get_model()->store_grades($data)){
    echo "success";
}
else echo "error";
die();



?>