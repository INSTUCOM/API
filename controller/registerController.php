<?php
session_start();
//require("mainController.php");
if (isset($_POST['id'])) {
	$id = trim($_POST['id']);
}
if (isset($_POST['first_name'])) {
	$first_name = trim($_POST['first_name']);
}
if (isset($_POST['last_name'])) {
	$last_name = trim($_POST['last_name']);
}
if(isset($_POST['password'])){
	$password = trim($_POST['password']);
    $password = md5($password);
}
if (isset($_POST['email'])) {
	$email = trim($_POST['email']);
}
if (isset($_POST['gender'])) {
	$gender = trim($_POST['gender']);
}
//die($directory);
if(empty($id)||empty($first_name)||empty($last_name)||empty($email)||empty($password)||empty($gender)){
    header("Location:register?text=empty");
}  
else{
$insertArray = array($id,$first_name,$last_name,$email,$password,$gender);

$register = new Instucom("user_details");
if($register->reg($insertArray)){
header("Location:login?text=registered");
}
else header("Location:register?text=error");
}


?>