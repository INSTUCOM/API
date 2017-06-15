<?php
defined('INDEX') or exit("Access denied! Request from an external source");
$postId = isset($_POST['post_id']) ? $_POST['post_id'] : null;

if($postId == null) die("error");

$deletePost = new Instucom("news");
if($deletePost->get_model()->delete_post($postId)){     //if not add new user events
    die("deleted");
}

else{
        die("error");
}


?>