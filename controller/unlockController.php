<?php
if(!isset($_SESSION['id'])){
    session_start();

}

if(isset($_POST['password'])){
	$password = $_POST['password'];
    $password = md5($password);
}
if($password == $_SESSION['password']){
    if(isset($_SESSION['lock'])){
        $_SESSION['lock'] = false;
    }
    if(isset($_SESSION['last_page'])){
    header("Location:".$_SESSION['last_page']);
    }
    else header("Location:dashboard");
}
else{
    header("Location:lock?text=incorrect");
}
	


?>