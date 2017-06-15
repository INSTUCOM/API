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

$data = new Instucom("news");
$news = $data->get_model()->get_data($options);

for($i = 0; $i < sizeof($news); $i++){
	foreach ($news[$i] as $key => $value) {
		if($key == "link"){

			$image = imagecreatefromjpeg(__SERVER_ROOT.$value);
			$imageSize = getimagesize(__SERVER_ROOT.$value);
			$size = min(imagesx($image), imagesy($image));
			$im2 = imagecrop($image, ['x' => abs(($imageSize[0]-$size)/2), 'y' => abs(($imageSize[1]-$size)/2), 'width' => $size, 'height' =>  $size]);
			if ($im2 !== FALSE) {
				$image = $im2;
			}
			ob_start();
			imagejpeg($image, NULL, 20);
			$imagestring = ob_get_contents();
			ob_end_clean();
			$news[$i][$key] =  base64_encode($imagestring);
			
		}
		if($key == "created"){
			date_default_timezone_set("Africa/Lagos");
			$dStart = new DateTime($value);
   			$dEnd  = new DateTime('NOW');
			$interval = date_diff($dStart, $dEnd);
			if($interval->y != 0){
				$news[$i][$key] = strtoupper(date_format(date_create($value), "F j, Y"));
			}
			else if($interval->m != 0){
				$news[$i][$key] = strtoupper(date_format(date_create($value), "F d"));
			}
			else if($interval->d != 0){
				if($interval->d == 1){
					$news[$i][$key] = $interval->d." day ago";
				}
				else $news[$i][$key] = $interval->d." days ago";
			}
			else if($interval->h != 0){
				if($interval->h == 1){
					$news[$i][$key] = $interval->h." hour ago";
				}
				else $news[$i][$key] = $interval->h." hours ago";
			}
			else if($interval->i != 0){
				if($interval->i == 1){
					$news[$i][$key] = $interval->i." minute ago";
				}
				else $news[$i][$key] = $interval->i." minutes ago";
			}
			else if($interval->s != 0){
					$news[$i][$key] = "just now";
			}
		}
	}
}


print_r(json_encode($news, JSON_UNESCAPED_SLASHES));

?>