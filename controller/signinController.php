<?php
defined('INDEX') or exit("Access denied! Request from an external source");
ini_set('memory_limit', '512M');
$options = json_decode(html_entity_decode(isset($_POST['options']) ? $_POST['options'] : null), true);
if($options == null){
	die("No options inputed");
}


	if(isset($options['email'])){
	$email = strtolower($options['email']);
	}
	if(isset($options['password'])){
	$password = $options['password'];
	}
	
	if(empty($email) || empty($password)){
		die("empty");
	}
	else{
	Instucom::__construct('');
	$type = Instucom::get_model()->check_email($email);
	if(!$type){
		die(json_encode(["status"=>"incorrect","userid"=>"","data"=>"","type"=>""]));
	}
	$s = new Instucom($type);
	die($s->login($email,$password));
	}

?>	