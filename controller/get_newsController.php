<?php

ini_set('memory_limit', '512M');

if (isset($_GET['id'])) {
	$id = trim($_GET['id']);
	//echo $id;
}

$options = json_decode(isset($_GET['options']) ? $_GET['options'] : null);
//die($options[0]["me"]);
$data = new Instucom("news");
//print_r($data->get_data());
$news = $data->get_data($options);
for($i = 0; $i < sizeof($news); $i++){
	foreach ($news[$i] as $key => $value) {
		if($key == "link"){
			$image = imagecreatefromjpeg($value);
			ob_start();
			imagejpeg($image);
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
				$news[$i][$key] = new Date("F j, Y", $value);
			}
			else if($interval->m != 0){
				$news[$i][$key] = new Date("F j", $value);
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