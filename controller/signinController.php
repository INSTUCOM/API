<?php
//include "mainController.php";
	if(isset($_POST['email'])){
	$email = $_POST['email'];
	}
	if(isset($_POST['password'])){
	$password = $_POST['password'];
	}
	
	if(empty($email) || empty($password)){
		header("Location:login?text=empty");
	}
	else{
	$s = new Instucom('user_details');
	//die("me");
	if($s->login($email,$password)){
		header("Location:dashboard");
	}
	else{
		header("Location:login?text=incorrect");
	}
}

?>