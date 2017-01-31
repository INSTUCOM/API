<?php


// if(file_exists("./config.php")){
// include "./config.php";
// }
// else if(file_exists("./../config.php")){
//   include "./../config.php";
// }
include dirname( __FILE__ ) ."./../config.php";


class Instucom_model
{
	

	private $conn;
	private $table;


	function __construct($table)
	{
		$this->dbconnect();
		$this->table = $table;
	}

	function dbconnect(){
        try {
            $this->conn = new PDO('mysql:host='.__SERVER.';dbname='.__DBNAME.';charset=utf8', __USER, __PASS);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected successfully";
        }
        catch(PDOException $e)
        {
            //echo "Connection failed: " . $e->getMessage();
        }
		
	}//end dbconnect

	function get_conn(){
		return $this->conn;
	}
	

	function get_item($id){
		$query = "SELECT * FROM pictures WHERE id=$id";
		$result = mysql_query($query);
		$temp = mysql_fetch_object($result);
		return $temp;
	}//end get_item

	
	


	function insert_into_table($insertArray) {
		$query = "";
		$query .= "INSERT INTO $this->table VALUES (0,";
		for ($x=0; $x < sizeof($insertArray); $x++ ) {
			$type = gettype($insertArray[$x]);
			if($type == "integer" || $insertArray[$x] == "0"){
				$query .= $insertArray[$x].","; 
			}
			else{
			$query .= "'$insertArray[$x]',";
			}
		}//end for
		$query = substr($query,0,strlen($query)-1);
		$query .= ")";
		$result = $this->conn->exec($query);
		if($result) {
			return TRUE;
		}
	}//end insert_into_table


	function login($email,$password){
    $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE email = :email");
    $stmt->bindParam(':email', $e_mail);
    $e_mail = $email;
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $all = $stmt->fetchAll();
	//print_r($all);
    $pword = $all[0]["password"];
    $device_id = $all[0]["identification"];
    $password = md5($password);

	if ($pword == $password){
		if (!isset($_SESSION)){					//check if session is started
			session_start();					//if not start session
			$_SESSION['id'] = $device_id;	//set session variables
			$_SESSION['first_name'] = $all[0]["first_name"];
			$_SESSION['last_name'] = $all[0]["last_name"];
			$_SESSION['email'] = $all[0]["email"];
			$_SESSION['password'] = $pword;
			$_SESSION['lock'] = false;
			$_SESSION['userid'] = $all[0]["id"];
			
			return true;
		}

	}
	else {
		return false;

	}
}//end login


/*
function get_id($name,$password){
    $query="SELECT * FROM client_details WHERE (client_name = '$name' && password='$password')";
	$result = mysql_query($query);
	$id=mysql_fetch_object($result);
    return $id->client_id;
}//end get_id
*/

function reg($insertArray){
    $query = "";
		$query .= "INSERT INTO $this->table VALUES (0,";
		for ($x=0; $x < sizeof($insertArray); $x++ ) {
			$type = gettype($insertArray[$x]);
			if($type == "integer"){
				$query .= $insertArray[$x].","; 
			}
			else{
			$query .= "'$insertArray[$x]',";
			}
		}//end for
		$query = substr($query,0,strlen($query)-1);
		$query .= ")";
		$result = $this->conn->exec($query);
		if($result) {			
           return true;
		}
}//end reg

function insert_multiple($insertArray) {	//datatype= associative array
		$query = "";
		$query .= "INSERT INTO $this->table VALUES ";
        for ($x=0; $x < sizeof($insertArray); $x++ ) {
        $query .= "(0,";
        $new_array = $insertArray[$x];
		for ($y=0; $y < sizeof($new_array); $y++ ) {
			$type = gettype($new_array[$y]);
			if($type == "integer"){
				$query .= $new_array[$y].","; 
			}
			else{
			$query .= "'$new_array[$y]',";
			}
		}//end for
		$query = substr($query,0,strlen($query)-1);
		$query .= "),";
        }//end for
        $query = substr($query,0,strlen($query)-1);
        //echo $query;
        
		$stmt = $this->conn->prepare($query);
		$result = $stmt->execute();
		if($result) {
			return true;
		}
        
        
	}//end insert_multiple

    function update_field($insertArray,$factor){	//
        $query = "";
        $query .= "UPDATE $this->table SET ";
        foreach ($insertArray as $key => $value) {
            $query .= " '".$key."'=";
            if(gettype($value) == "integer"){
                $query .= $value.",";
            }
            else $query .= "'".$value."',";
        }
        $query = substr($query,0,strlen($query)-1);
		if(!empty($factor)){
        $query .= " WHERE ";
        foreach ($factor as $key => $value) {
            $query .= "$key = '$value'";
        }
		}
        //echo $query;
        
        $stmt = $this->conn->prepare($query);
		$result = $stmt->execute();
		if($result) {
			return true;
		}
		else return false;
        
    }//end update_field

	public function get_devices(){
		if(!isset($_SESSION['id'])){
			session_start();
		}
		//echo "got here";
		$query = "SELECT * FROM $this->table WHERE user_id=".$_SESSION["userid"];
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$devices = $stmt->fetchAll();
		//print_r($devices);
		//echo $_SESSION["userid"];
		return $devices;

	}//end get_devices

	public function get_data(){
		if(!isset($_SESSION['id'])){
			session_start();
			$_SESSION["userid"] = 1;
		}
		//echo "got here";
		$query = "SELECT ".$this->table.".id,title,body,name as author,created,link,(SELECT COUNT(*) FROM likes WHERE ".$this->table.".id=likes.news_id) likes_no FROM ".$this->table." JOIN attachments JOIN users JOIN student WHERE attachments.id=attachment_id AND ".$this->table.".author_id=users.id AND users.unique_id=student.id";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$data = $stmt->fetchAll();
		//print_r($devices);
		//echo $_SESSION["userid"];
		return $data;

	}//end get_sensors


	function set($device_id,$status){
		$query = "UPDATE $this->table SET status=$status WHERE id=$device_id";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$query = "SELECT pin FROM $this->table WHERE id=$device_id";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    	$all = $stmt->fetchAll();
		$res = $all[0]["pin"];
		//echo $res;
		return $res;
	}


	



}
?>