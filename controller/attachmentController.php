<?php
defined('INDEX') or exit("Access denied! Request from an external source");
ini_set('memory_limit', '512M');
$data = (isset($_POST['featured_image'])) ? $_POST['featured_image'] : null;
$name = (isset($_POST['name'])) ? $_POST['name'] : null;
$quality = (isset($_POST['quality'])) ? $_POST['quality'] : 100;
$temp = explode(".",$name);
$index = sizeof($temp) - 1;
$type = $temp[$index];
if(sizeof($temp) >= 2){
    $name = "";
    for($i = 0; $i< sizeof($temp)-1; $i++){
        $name .= $temp[$i];
    }
}
$data = base64_decode($data);
$dir = 'uploads/'.date('Y');
if(!file_exists($dir)){
    
    $create = mkdir($dir);
    $dir = 'uploads/'.date('Y')."/".date('m');
        $create2 = mkdir($dir);
}
else{
    $dir = 'uploads/'.date('Y')."/".date('m');
    if(!file_exists($dir))
    {
        $create2 = mkdir($dir);
    }
}
$output = $dir."/".$name."_".time();
switch($type){
    case "jpg":
    case "JPG":
    $output_file = $output.".jpg";
    $ifp = fopen( $output_file, 'wb' );
    fwrite($ifp, $data);
    fclose($ifp); 
    $image = imagecreatefromjpeg($output_file);
    imagejpeg($image, $output_file, $quality);
    imagedestroy($image);
    break;
    case "png":
    case "PNG":
    $output_file = $output.".png";
    file_put_contents($output_file, $data);
    $image = imagecreatefrompng($output_file);
    $output_file = $output.".jpg";
    imagejpeg($image, $output_file, $quality);
    imagedestroy($image);
    break;
    default:
    $output_file = $output.".jpg";
    $ifp = fopen( $output_file, 'wb' );
    fwrite($ifp, $data);
    fclose($ifp);
    break;
}
$output_file = $output.".jpg";
echo $output_file;






?>