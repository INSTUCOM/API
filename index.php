<?php
header("Access-Control-Allow-Origin:*");
include("controller/urlController.php");

$uri = $_SERVER['REQUEST_URI'];
$url = new URL($uri);
$url->get_page();
$url->render();

/*
if(isset($_GET['id'])){

}
else {
echo "page doesn't exist";
}
*/
//echo $uri;
/*
	$head = "views/head.php";
	$column = "views/column.php";
	if(isset($_GET['content'])){
		$link = $_GET['content'];
		$link = strstr($link,"C");
		$content = "views/".$_GET['content'].".php";
		if($link == "Controller"){
		$content = "controller/".$_GET['content'].".php";
	}
	}

	else{
		$content = "views/test.php";
	}

	if(!file_exists($content)){
		$content = "views/test.php";
	}
	

	//include $head;
	//include $column;
?>
	<div id='content'>
<?php
	include $content;
    */


?>
