<?php
defined('INDEX') or exit("Access denied! Request from an external source");
$options = json_decode(html_entity_decode(isset($_REQUEST['options']) ? $_REQUEST['options'] : null), true);
if($options == null){
	die("No options inputed");
}

$point = (isset($options["point"])) ? $options["point"] : null;
$events = isset($options['events']) ? $options['events'] : null;
$userid = isset($options['user_id']) ? $options['user_id'] : null;
$_SESSION["userid"] = $userid;
if($events == null) die("events empty");
if($userid == null) die("no user");

$newEvent = new Instucom("events");
$created = date('y-m-d H:i:s');
if(!$newEvent->get_model()->event_added($userid)){        //check if user's event already exists in the db
    if($newEvent->get_model()->insert_into_table([$userid,$events,$created,$created])){     //if not add new user events
        die("created");
    }
}

else{        //if user's event already exists in the db
    if($newEvent->get_model()->update_fields(["event"=>$event,"modified"=>$created],["userid"=>$userid])){ //update the user's event'
        die("updated");
    }
}

?>