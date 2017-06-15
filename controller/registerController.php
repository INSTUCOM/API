<?php
defined('INDEX') or exit("Access denied! Request from an external source");
ini_set('memory_limit', '512M');
$options = json_decode(html_entity_decode(isset($_POST['options']) ? $_POST['options'] : null), true);
if($options == null){
	die("No options inputed");
}

@date_default_timezone_set("Africa/Lagos");
$created = date("Y-m-d H:i:s");

switch($options['type']){
	case "student":
	if(!isset($options["first_name"]) || !isset($options["last_name"]) || !isset($options["program"]) || !isset($options["matric_no"]) || !isset($options['department']) || !isset($options['level']) || !isset($options["email"]) || !isset($options["password"])){
		die(json_encode(["status"=>"empty","userid"=>"","data"=>""]));
	}
	$details = new Instucom("department");
	$ids = $details->get_model()->get_dept_level_id($options['program'],$options['level']);
	$insertArray = array($options["first_name"],$options["last_name"],$ids["program_id"],$options["matric_no"],$ids['department_id'],$ids['level_id'],strtolower($options["email"]),md5($options["password"]),$created);
	$new = new Instucom('student');
	if(!$new->get_model()->check_user(["email"=>strtolower($options['email']),"matric_no"=>$options['matric_no']])){
		if($new->get_model()->insert_into_table($insertArray)){
			echo $new->get_model()->login(strtolower($options["email"]),$options["password"]);
		}
	}
	else{
		echo json_encode(["status"=>"duplicate","userid"=>"","data"=>""]);
	}
	die();
	break;
	case "lecturer":
	if(!isset($options["first_name"]) || !isset($options["last_name"]) || !isset($options['department']) || !isset($options['level']) || !isset($options['email']) || !isset($options['password'])){
		die(json_encode(["status"=>"empty","userid"=>"","data"=>""]));
	}
	$details = new Instucom("department");
	$ids = $details->get_model()->get_dept_level_id_dept($options['department'],$options['level']);
	$insertArray = array($options["title"],$options["first_name"],$options["last_name"],$ids['department_id'],$ids['level_id'],strtolower($options["email"]),md5($options["password"]),$created);
	$new = new Instucom('lecturer');
	if(!$new->get_model()->check_email(strtolower($options['email']))){
		if($new->get_model()->insert_into_table($insertArray)){
			echo $new->get_model()->login(strtolower($options["email"]),$options["password"]);
		}
	}
	else{
		echo json_encode(["status"=>"duplicate","userid"=>"","data"=>""]);
	}
	die();
	break;
	case "mentor":
	if(!isset($options["first_name"]) || !isset($options["last_name"]) || !isset($options['profession']) || !isset($options['association']) || !isset($options['company']) || !isset($options['email']) || !isset($options['password'])){
		die(json_encode(["status"=>"empty","userid"=>"","data"=>""]));
	}
	$insertArray = array($options["first_name"],$options["last_name"],$options['profession'],$options['association'],$options['company'],$options['email'],$options['password'],$created);
	$new = new Instucom('mentor');
	if(!$new->get_model()->check_email(strtolower($options['email']))){
		if($new->get_model()->insert_into_table($insertArray)){
			echo $new->get_model()->login(strtolower($options["email"]),$options["password"]);
		}
	}
	else{
		echo json_encode(["status"=>"duplicate","userid"=>"","data"=>""]);
	}
	die();
	break;
	case "blogger":
	die(json_encode(["status"=>"error","userid"=>"","data"=>""]));
	break;
	default:
	exit("no type selected");
	die();
	break;
}



?>