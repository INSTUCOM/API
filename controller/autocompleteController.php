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
$field = (isset($options["field"])) ? $options["field"] : null;
$factor = (isset($options["factor"])) ? $options["factor"] : null;

$model = new Instucom("");
switch ($field) {
    case 'department':
        $data = $model->get_model()->get_departments($factor);
        if($data != 'error'){
            echo json_encode(['status' => 'success', 'data' => $data]);
        }
        else echo json_encode(['status' => 'error', 'data' => '']);
        die();
        break;
    case 'program':
        $data = $model->get_model()->get_programs($factor);
        if($data != 'error'){
            echo json_encode(['status' => 'success', 'data' => $data]);
        }
        else echo json_encode(['status' => 'error', 'data' => '']);
        die();
        break;
    case 'level':
        $data = $model->get_model()->get_levels();
        if($data != 'error'){
            echo json_encode(['status' => 'success', 'data' => $data]);
        }
        else echo json_encode(['status' => 'error', 'data' => '']);
        die();
        break;
    case 'course':
        $data = $model->get_model()->get_courses();
        if($data != 'error'){
            echo json_encode(['status' => 'success', 'data' => $data]);
        }
        else echo json_encode(['status' => 'error', 'data' => '']);
        die();
        break;
    default:
        echo json_encode(['status' => 'error', 'data' => '']);
        die();
        break;
}



?>