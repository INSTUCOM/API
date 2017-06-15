<?php

if($_POST)
{
$q=$_POST['searchword'];
$q=str_replace("@","",$q);
$q=str_replace(" ","%",$q);
$mention = new Instucom('users');
$data = $mention->get_model()->get_mention($q);
foreach ($data as $key => $row) {
$username=$row['username'];
$img=$row['profile_pic'];
$userid = $row['id'];
?>
<div class="display_box" >
<img src="<?= $img ?>" class="image" />
<a href="<?= APP_PATH.'users?user='.$username ?>" class='addname' title='<?= "".$username ?>'>
<?= $username ?> </a>
</div>
<?php
}
}
?>