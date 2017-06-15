<?php
defined('INDEX') or exit("Access denied! Request from an external source");
date_default_timezone_set("Africa/Lagos");
$options = json_decode(html_entity_decode(isset($_GET['options']) ? $_GET['options'] : null), true);
if($options == null){
	die("No options inputed");
}
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$_SESSION["userid"] = $options["user_id"];
$post_id = $options["post_id"];

$data = new Instucom("news");
$news = $data->get_model()->get_news($post_id);

	foreach ($news as $key => $value) {
		if($key == "link"){
			$image = imagecreatefromjpeg(__SERVER_ROOT.$value);
			ob_start();
			imagejpeg($image);
			$imagestring = ob_get_contents();
			ob_end_clean();
			$news[$key] =  base64_encode($imagestring);
			
		}
		if($key == "created"){
			$dStart = new DateTime($value);
   			$dEnd  = new DateTime('NOW');
			$interval = date_diff($dStart, $dEnd);
			if($interval->y != 0){
				$news[$key] = strtoupper(date_format(date_create($value), "F j, Y"));
			}
			else if($interval->m != 0){
				$news[$key] = strtoupper(date_format(date_create($value), "F d"));
			}
			else if($interval->d != 0){
				if($interval->d == 1){
					$news[$key] = strtoupper($interval->d." day ago");
				}
				else $news[$key] = strtoupper($interval->d." days ago");
			}
			else if($interval->h != 0){
				if($interval->h == 1){
					$news[$key] = strtoupper($interval->h." hour ago");
				}
				else $news[$key] = strtoupper($interval->h." hours ago");
			}
			else if($interval->i != 0){
				if($interval->i == 1){
					$news[$key] = strtoupper($interval->i." minute ago");
				}
				else $news[$key] = strtoupper($interval->i." minutes ago");
			}
			else if($interval->s != 0){
					$news[$key] = strtoupper("just now");
			}
		}

		if($key == 'body'){
			$content= stripslashes (htmlspecialchars ($news[$key]));
			$news[$key] = (! get_magic_quotes_gpc ()) ? html_entity_decode(addslashes ($content)) : html_entity_decode($content);
		}
	}



print_r(json_encode($news, JSON_UNESCAPED_SLASHES));

?>