<?php
defined('INDEX') or exit("Request from an external source");
ini_set('memory_limit', '512M');

$options = json_decode(html_entity_decode(isset($_POST['options']) ? $_POST['options'] : null), true);
if(!isset($_SESSION['userid'])){
    session_start();
    if(!isset($_SESSION['userid'])){
        die("Not logged in");
    }
    $author_id = $_SESSION['userid'];
}

$created  = date('Y-m-d H:i:s');
if(isset($options['attachment'])){   
$attachmentArray = array('image',$options['attachment']);
$att = new Instucom("attachments");
$att->add($attachmentArray);
$attachment_id = $att->model_instance()->lastInsertId;
}
else{
    $attachment_id = null;
}
$postArray = array(isset($options['title']) ? $options['title'] : "", isset($options['body']) ? $options['body'] : "", $attachment_id, isset($options['sub_cat']) ? $options['sub_cat'] : "", isset($options['master_cat']) ? $options['master_cat'] : "", $author_id, $created);
$post = new Instucom("news");
if($post->add($postArray)){
    echo "success";
}
else echo "failed";




?>
