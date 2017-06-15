<?php
ini_set('memory_limit', '512M');
function unhtmlentities ($string) {
   $trans_tbl =get_html_translation_table (HTML_ENTITIES );
   $trans_tbl =array_flip ($trans_tbl );
   return strtr ($string ,$trans_tbl );
}


$options = json_decode(html_entity_decode(isset($_REQUEST['options']) ? $_GET['options'] : null), true);

if (session_status() == PHP_SESSION_NONE) {
    @session_start();
}
@date_default_timezone_set("Africa/Lagos");
$_SESSION["userid"] = $options["user_id"];
$post_id = $options["post_id"];
$comment = (isset($_POST["comment"])) ? $_POST["comment"] : null;

//$comment = (isset($comment)) ? unhtmlentities (addslashes (trim ($comment))) : null;
preg_match_all('/\s*@(.+?)\s/', $comment, $matches);
$mentions = (isset($matches[1])) ? $matches[1] : null;
$replace = array();
foreach ($mentions as $key => $value) {
    $mentions[$key] = '@'.$value;
    $replace[$key] = '<a href="'.APP_PATH.'users?user='.$value.'" title="'.$value.'" target="blank">'.'@'.$value.'</a>';
}
if(sizeof($replace) == sizeof($mentions)){
    $comment = str_replace($mentions,$replace,$comment);
}
$comment = (isset($comment)) ? unhtmlentities (addslashes (trim ($comment))) : null;
if($comment == null){
    die('error');
}
$created = date("Y-m-d G:i:s");
$insertArray = array($comment,$post_id,$options['user_id'],$created);

$data = new Instucom("comments");
if($data->comment_on_post($insertArray)){
    $content= stripslashes (htmlspecialchars ($comment));
    $comment = (! get_magic_quotes_gpc ()) ? html_entity_decode(addslashes ($content)) : html_entity_decode($content);
    echo json_encode(['status' => 'success', 'data' => $comment]);
}
else echo json_encode(['status' => 'error']);




?>