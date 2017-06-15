<?php

include dirname( __FILE__ ) ."./../config.php";


class Instucom_model
{
	

	private $conn;
	private $table;


	function __construct($table){
		$this->dbconnect();
		$this->table = $table;
	}//end __construct

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
	}//end get_conn
	
	function insert_into_table($insertArray) {		//insert valus into set table from an array
		$query = "";
		$query .= "INSERT INTO $this->table VALUES (0,";
		for ($x=0; $x < sizeof($insertArray); $x++ ) {
			$type = gettype($insertArray[$x]);		//get the datatype of the current insertvalue
			if($type == "integer" || $insertArray[$x] == "0"){
				$query .= $insertArray[$x].","; 	//insert as integer value
			}
			else{
			$query .= "'$insertArray[$x]',";		//insert as string value
			}
		}//end for
		$query = substr($query,0,strlen($query)-1);	//remove stray comma(,)
		$query .= ")";
		$result = $this->conn->exec($query);		//execute
		if($result) {
			return true;
		}
		else return false;
	}//end insert_into_table


	function login($email,$password){		//login using email and password
		$stmt = $this->conn->prepare("SELECT * FROM ".$this->table." WHERE email = :email");
		$stmt->bindParam(':email', $e_mail);
		$e_mail = $email;
		$stmt->execute();
		$all = $stmt->fetch(PDO::FETCH_ASSOC);
		$pword = $all["password"];
		$password = md5($password);				
		if ($pword == $password){							//check if details exists from the unique table set.
			$stmt1 = $this->conn->prepare("SELECT * FROM users WHERE type= '".$this->table."' AND unique_id =".$all["id"]);
			$stmt1->execute();
			$d = $stmt1->fetch(PDO::FETCH_ASSOC);
			if (session_status() == PHP_SESSION_NONE) {
					@session_start();
			}				
				switch ($this->table) {
					case 'student':
						$query1 = "SELECT ".$this->table.".first_name, ".$this->table.".last_name ,matric_no,email,program.name as program,department.name as department,level.identifier as level FROM ".$this->table." JOIN program ON program.id=program_id JOIN department ON department.id=".$this->table.".department_id JOIN level ON level.id=level_id WHERE ".$this->table.".id=".$all['id'];
						//echo $query;
						$stmt2 = $this->conn->prepare($query1);
						$stmt2->execute();
						$data = $stmt2->fetch(PDO::FETCH_ASSOC);
						$_SESSION['first_name'] = $all["first_name"];
						$_SESSION['last_name'] = $all["last_name"];
						$_SESSION['userid'] = $d["id"];
						$temp = array("status"=>"success","userid"=>$_SESSION['userid'],"data"=>$data,"type"=>"student");
						return json_encode($temp);
						break;
					case 'lecturer':
						$query1 = "SELECT ".$this->table.".first_name, ".$this->table.".last_name ,email,program.name as program,department.name as department,level.identifier as level FROM ".$this->table." JOIN program ON program.id=program_id JOIN department ON department.id=".$this->table.".department_id JOIN level ON level.id=level_id WHERE ".$this->table.".id=".$all['id'];
						//echo $query;
						$stmt2 = $this->conn->prepare($query1);
						$stmt2->execute();
						$data = $stmt2->fetch(PDO::FETCH_ASSOC);
						$_SESSION['first_name'] = $all["first_name"];
						$_SESSION['last_name'] = $all["last_name"];
						$_SESSION['userid'] = $d["id"];
						$temp = array("status"=>"success","userid"=>$_SESSION['userid'],"data"=>$data,"type"=>"lecturer");
						return json_encode($temp);
						break;
					case 'mentor':
						$query1 = "SELECT ".$this->table.".first_name, ".$this->table.".last_name ,email,profession,association,company FROM ".$this->table." WHERE ".$this->table.".id=".$all['id'];
						//echo $query;
						$stmt2 = $this->conn->prepare($query1);
						$stmt2->execute();
						$data = $stmt2->fetch(PDO::FETCH_ASSOC);
						$_SESSION['first_name'] = $all["first_name"];
						$_SESSION['last_name'] = $all["last_name"];
						$_SESSION['userid'] = $d["id"];
						$temp = array("status"=>"success","userid"=>$_SESSION['userid'],"data"=>$data,"type"=>"mentor");
						return json_encode($temp);
						break;
					default:
						$temp = array("status"=>"incorrect","userid"=>"","data"=>"");
						return json_encode($temp);
						break;
				}
				

		}
		else {
			$temp = array("status"=>"incorrect","userid"=>"","data"=>"");
			return json_encode($temp);

		}
	}//end login

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

	function check_user($user){
		$query = "SELECT * FROM ".$this->table." WHERE ";
		foreach ($user as $key => $value) {
			$query .= $key." = '".$value."' || "; 
		}
		$query = substr($query,0,strlen($query)-4);
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if($stmt->rowCount())
			return true;
		else {
			if(!self::check_email($user['email']))
				return false;
			else{
				return true;
			}
		}
		
	}//end check_user

	function check_email($email){
		$query = "SELECT * FROM student WHERE email=?";
		$stmt = $this->conn->prepare($query);
		$stmt->execute([$email]);
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if($stmt->rowCount()){
			return 'student';
		}
		else{
			$query = "SELECT * FROM lecturer WHERE email=?";
			$stmt = $this->conn->prepare($query);
			$stmt->execute([$email]);
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount()){
				return 'lecturer';
			}
			else{
				$query = "SELECT * FROM mentor WHERE email=?";
				$stmt = $this->conn->prepare($query);
				$stmt->execute([$email]);
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				if($stmt->rowCount()){
					return 'mentor';
				}
				else return false;
			}
		}

	}

    function update_fields($insertArray,$factor){	//
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
            $query .= "$key = '$value' AND ";
        }
		$query = substr($query,0,strlen($query)-4);
		}
        //die($query);
        
        $stmt = $this->conn->prepare($query);
		$result = $stmt->execute();
		if($result) {
			return true;
		}
		else return false;
        
    }//end update_fields

	function get_data($options){
		if(isset($options)){
			if(isset($options['last'])){
				if(trim($options['last']) != 0 && trim($options['last']) != ""){
					$next = " AND ".$this->table.".id < ".$options['last'];
				}
				else $next = "";
			}
			else{
				$next = "";
			}
			if(trim($options['master_cat']) != "" && trim($options['sub_cat']) != ""){
				if(trim($options['master_cat']) == "promotion"){
					$loggedin = $this->get_dept_fac_sch($_SESSION['userid']);
					$query = "SELECT ".$this->table.".id,title,student.first_name as author,".$this->table.".created,link,(SELECT COUNT(*) FROM likes WHERE likes.liker=".$_SESSION["userid"].") if_liked,(SELECT COUNT(*) FROM likes WHERE likes.news_id=".$this->table.".id) likes_no FROM ".$this->table." JOIN news_rule ON news_rule.news_id = ".$this->table.".id JOIN users ON users.id = ".$this->table.".author_id AND users.type='student' JOIN student ON student.id = users.unique_id JOIN master_categories ON master_categories.id = ".$this->table.".master_category_id AND master_categories.category_name = '".$options['master_cat']."' JOIN sub_categories ON sub_categories.id = ".$this->table.".sub_category_id AND sub_categories.category_name = '".$options['sub_cat']."' JOIN attachments ON attachments.id = ".$this->table.".attachment_id JOIN department ON department.id = student.department_id WHERE (student.department_id = ".$loggedin['department_id']." && news_rule.level = 1) || (department.faculty_id = ".$loggedin['faculty_id']." && news_rule.level = 2) || (department.school_id = ".$loggedin['school_id']." && news_rule.level = 3) || (news_rule.level = 4)".$next." ORDER BY ".$this->table.".id DESC LIMIT 10";

				}
				else{
					$query = "SELECT ".$this->table.".id,title,blogger.first_name as author,".$this->table.".created,link,(SELECT COUNT(*) FROM likes WHERE likes.liker=".$_SESSION["userid"].") if_liked,(SELECT COUNT(*) FROM likes WHERE likes.news_id=".$this->table.".id) likes_no FROM ".$this->table." JOIN attachments JOIN users JOIN master_categories ON master_categories.category_name='".$options['master_cat']."' JOIN sub_categories ON sub_categories.category_name='".$options['sub_cat']."' JOIN blogger WHERE attachments.id=attachment_id AND ".$this->table.".author_id=users.id AND users.unique_id=blogger.id AND master_category_id=master_categories.id AND sub_category_id=sub_categories.id".$next." ORDER BY ".$this->table.".id DESC LIMIT 10";
				}
			}
			else if(trim($options['master_cat']) != "" && trim($options['sub_cat']) == ""){
				if(trim($options['master_cat']) == "promotion"){
					$query = null;
				}
				else{
					$query = "SELECT ".$this->table.".id,title,blogger.first_name as author,".$this->table.".created,link,(SELECT COUNT(*) FROM likes WHERE likes.liker=".$_SESSION["userid"].") if_liked,(SELECT COUNT(*) FROM likes WHERE likes.news_id=".$this->table.".id) likes_no FROM ".$this->table." JOIN attachments JOIN users JOIN master_categories ON master_categories.category_name='".$options['master_cat']."' JOIN blogger WHERE attachments.id=attachment_id AND ".$this->table.".author_id=users.id AND users.unique_id=blogger.id AND master_category_id=master_categories.id".$next." ORDER BY ".$this->table.".id DESC LIMIT 10";	
				}
			}
			else if(trim($options['master_cat']) == "" && trim($options['sub_cat']) != ""){				
					$query = "SELECT ".$this->table.".id,title,blogger.first_name as author,".$this->table.".created,link,(SELECT COUNT(*) FROM likes WHERE likes.liker=".$_SESSION["userid"].") if_liked,(SELECT COUNT(*) FROM likes WHERE ".$this->table.".id=likes.news_id) likes_no FROM ".$this->table." JOIN attachments JOIN users JOIN blogger JOIN sub_categories ON sub_categories.category_name='".$options['sub_cat']."' JOIN student WHERE attachments.id=attachment_id AND ".$this->table.".author_id=users.id AND users.unique_id=blogger.id AND sub_category_id=sub_categories.id".$next." ORDER BY ".$this->table.".id DESC LIMIT 10";

			}
		}
		else{
			$query = "SELECT ".$this->table.".id,title,name as author,".$this->table.".created,link,(SELECT COUNT(*) FROM likes WHERE likes.liker=".$_SESSION["userid"]." AND likes.news_id=$id) if_liked,(SELECT COUNT(*) FROM likes WHERE ".$this->table.".id=likes.news_id) likes_no FROM ".$this->table." JOIN attachments JOIN users JOIN blogger WHERE attachments.id=attachment_id AND ".$this->table.".author_id=users.id AND users.unique_id=blogger.id".$next." ORDER BY ".$this->table.".id DESC LIMIT 10";
		}
		if($query == null) exit('invalid request');
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$data = $stmt->fetchAll();
		return $data;

	}//end get_data

	function get_news($id){
		
		
		$query = "SELECT ".$this->table.".id,title,body,".$this->table.".author_id,IF(".$this->table.".master_category_id = 3, student.first_name, blogger.first_name) as author,
				 ".$this->table.".created,link,(SELECT COUNT(*) FROM likes WHERE likes.news_id=".$this->table.".id) likes_no,(SELECT COUNT(*) FROM comments WHERE comments.news_id=".$this->table.".id) comments_no,
				 (SELECT COUNT(*) FROM likes WHERE likes.liker=".$_SESSION["userid"]." AND likes.news_id=$id) if_liked FROM ".$this->table." LEFT JOIN attachments ON attachments.id=".$this->table.".attachment_id LEFT JOIN users ON users.id = ".$this->table.".author_id LEFT JOIN blogger ON blogger.id=users.unique_id LEFT JOIN student ON student.id=users.unique_id WHERE news.id=$id LIMIT 1";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$data = $stmt->fetch(PDO::FETCH_ASSOC);
		return $data;
	}//end get_news

	function like_post($post_id){
		date_default_timezone_set("Africa/Lagos");
		$created = date("Y-m-d G:i:s");
		$query = "SELECT COUNT(id) AS numb FROM ".$this->table." WHERE ".$this->table.".liker = ? AND ".$this->table.".news_id = ?";
		$stmt = $this->conn->prepare($query);
		$stmt->execute([$_SESSION['userid'],$post_id]);
		$ret = $stmt->fetchObject(__CLASS__,[$this->table]);
		
		if($ret->numb == 0){
			if($this->insert_into_table([$post_id,$_SESSION['userid'],$created])){
				echo "success";
			}
		}
		else{
			$query = "DELETE FROM likes WHERE news_id=? AND liker=?";
			$stmt = $this->conn->prepare($query);
			if($stmt->execute([$post_id,$_SESSION['userid']])){
				echo "success";
			}
		}

	}//end like_post

	function get_dept_level_id($program,$level){
		$query = "SELECT program.id as program_id, program.department_id as department_id, level.id as level_id FROM program JOIN level ON level.identifier = ? WHERE program.name = ? ";
		$stmt = $this->conn->prepare($query);
		$stmt->execute([$level,$program]);
		$ids = $stmt->fetch(PDO::FETCH_ASSOC);
		
		return $ids;
	}//end get_dept_level_id

	function get_dept_level_id_dept($department,$level){
		$query = "SELECT department.id as department_id, level.id as level_id FROM department JOIN level ON level.identifier = ? WHERE department.name = ? ";
		$stmt = $this->conn->prepare($query);
		$stmt->execute([$level,$department]);
		$ids = $stmt->fetch(PDO::FETCH_ASSOC);
		
		return $ids;
	}//end get_dept_level_id

	function get_dept_fac_sch($id){
		$query = "SELECT student.department_id as department_id, department.faculty_id as faculty_id, department.school_id as school_id FROM student JOIN department ON student.department_id = department.id JOIN users ON users.id = ? WHERE student.id = users.unique_id LIMIT 1";
		$stmt = $this->conn->prepare($query);
		$stmt->execute([$id]);
		$ids = $stmt->fetch(PDO::FETCH_ASSOC);
		return $ids;
	}//end get_dept_fac_sch
	
	function get_promotions($options){
		$loggedin = $this->get_dept_fac_sch($_SESSION['userid']);
		if(isset($options)){
			if(trim($options['last']) != 0 || trim($options['last']) != ""){
				$next = " AND ".$this->table.".id < ".$options['last'];
			}
			else $next = "";
			$query = "SELECT ".$this->table.".id,title,name as author,".$this->table.".created,link,(SELECT COUNT(*) FROM likes WHERE likes.news_id=".$this->table.".id) likes_no,master_categories.id,sub_categories.id FROM ".$this->table." JOIN news_rule ON news_rule.news_id = ".$this->table.".id JOIN users ON users.id = ".$this->table.".author_id JOIN student ON student.id = users.unique_id JOIN sub_categories ON sub_category.id = ".$this->table.".sub_categories AND sub_category.name = ? JOIN department ON department.id = student.department_id WHERE (student.department_id = ? && news_rule.level = 1) || (department.faculty_id = ? && news_rule.level = 2) || (department.school_id = ? && news_rule.level = 3) || (news_rule.level = 4)".$next." LIMIT 10";
			$stmt = $this->conn->prepare($query);
			$stmt->execute([$options['sub_cat'],$loggedin['department_id'],$loggedin['faculty_id'],$loggedin['school_id']]);
			$news = $stmt->fetch(PDO::FETCH_ASSOC);
			return $news;
		}
	}//end get_promotions

	function get_user_courses($semester,$level){
		$query = "SELECT  course.id AS id, course.course_code,course.course_description FROM user_courses JOIN course ON course.id=user_courses.course_id WHERE user_id = ".$_SESSION['userid']." AND active=1 AND semester=".$semester." AND level_id=".$level;
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return $result;
	}//end get_courses

	function get_coursemates(){
		$query = "SELECT users.id FROM  WHERE users JOIN student ON student.program_id=".$this->get_student_program_id();
		$stmt = $this->conn->prepare($query);
			$stmt->execute();
			$temp = $stmt->fetch(PDO::FETCH_ASSOC); //list of coursemates
			return $temp;
	}//end get_coursemates

	function get_deptmates(){
		$query = "SELECT users.id FROM  WHERE users JOIN student ON student.id=users.unique_id JOIN program ON program.department_id=".$this->get_student_dept_id().' WHERE users.id='.$_SESSION['userid'];
		$stmt = $this->conn->prepare($query);
			$stmt->execute();
			$temp = $stmt->fetch(PDO::FETCH_ASSOC); //list of coursemates
			return $temp;
	}//end get_deptmates

	function get_student_program_id(){
		$query = "SELECT student.program_id FROM student JOIN users ON users.id=".$_SESSION['userid']." WHERE student.id = users.unique_id";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchObject(__CLASS__,[$this->table]);
		return $result->program_id;
	}//end get_student_program_id

	function get_student_dept_id(){
		$query = "SELECT program.department_id FROM program JOIN student ON student.program_id = program.id JOIN users ON users.id=".$_SESSION['userid']."  AND student.id = users.unique_id";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchObject(__CLASS__,[$this->table]);
		return $result->program_id;
	}//end get_student_program_id

	function event_added($userid){
		$query = "SELECT * FROM ".$this->table." WHERE userid=?";
		$stmt = $this->conn->prepare($query);
		$stmt->execute([$userid]);
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return $stmt->rowCount();
	}//end event_added

	function get_events($userid){
		$query = "SELECT event FROM ".$this->table." WHERE user_id=?";
		$stmt = $this->conn->prepare($query);
		$status = $stmt->execute([$userid]);
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if($status)
		return $result['event'];
		else return "error";
	}//end get_events

	function get_categories(){
		$query = "SELECT master_categories.category_name AS master_cat, sub_categories.category_name AS sub_cat FROM ".$this->table." JOIN master_categories ON master_categories.id = ".$this->table.".master_category_id JOIN sub_categories ON sub_categories.id = ".$this->table.".sub_category_id";
		$stmt = $this->conn->prepare($query);
		if($stmt->execute()){
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
			
		}
		
	}//end get_categories

	function get_blogger_news($bloggerId, $time, $page=''){
		if(isset($page)){
			if(trim($page) != 0 && trim($page) != "" && trim($page) != 1){
				$limit = (($page - 1) * 10);
			}
			else $limit = 0;
		}
		else{
			$limit = 0;
		}
				
		$query = "SELECT ".$this->table.".id,title,blogger.first_name as author,".$this->table.".created,link, (SELECT COUNT(*) FROM likes WHERE likes.news_id=".$this->table.".id) likes, (SELECT COUNT(*) FROM comments WHERE comments.news_id=".$this->table.".id) comments, (SELECT COUNT(*) FROM shares WHERE shares.news_id=".$this->table.".id) shares FROM ".$this->table." JOIN attachments JOIN users ON users.id=".$bloggerId." JOIN master_categories JOIN sub_categories JOIN blogger WHERE attachments.id=attachment_id AND ".$this->table.".author_id=users.id AND users.unique_id=blogger.id AND master_category_id=master_categories.id AND sub_category_id=sub_categories.id AND news.created > '".$time."' ORDER BY ".$this->table.".id DESC LIMIT ".$limit.",10";		
		if($query == null) exit(null);
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$temp = $stmt->fetchAll();
		$data['news'] = $temp;
		
		$query = "SELECT COUNT(".$this->table.".id) AS total FROM ".$this->table." JOIN attachments JOIN users ON users.id=".$bloggerId." JOIN master_categories JOIN sub_categories JOIN blogger WHERE attachments.id=attachment_id AND ".$this->table.".author_id=users.id AND users.unique_id=blogger.id AND master_category_id=master_categories.id AND sub_category_id=sub_categories.id AND news.created > '".$time."'";
		$stmt2 = $this->conn->prepare($query);
		$stmt2->execute();
		$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
		$total = $row2['total'];
		if($total % 10 != 0){
			$no_of_pages = ($total/10) + 1;
		}
		else{
			$no_of_pages = ($total/10);
		}
		$no_of_pages = intval($no_of_pages);
		$data['no_of_pages'] = $no_of_pages;
		return $data;

	}//end get_blogger_news

	function get_news_tab_stat($bloggerId, $time){
		$query = "SELECT (SELECT COUNT(likes.id) FROM likes JOIN news ON news.id = likes.news_id AND news.author_id = ".$bloggerId." WHERE likes.created > '".$time."') likes, (SELECT COUNT(comments.id) FROM comments JOIN news ON news.id = comments.news_id AND news.author_id = ".$bloggerId." WHERE comments.created > '".$time."') comments, (SELECT COUNT(shares.id) FROM shares JOIN news ON news.id = shares.news_id AND news.author_id = ".$bloggerId." WHERE shares.created > '".$time."') shares";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}//end get_news_tab_stat

	function get_news_graph_stat($bloggerId, $time){
		$months = ['jan','feb','march','april','may','june','july','aug','sept','oct','nov','dec'];
		$query1 = 'SELECT ';
		$query2 = 'SELECT ';
		$query3 = 'SELECT ';
		foreach ($time as $key => $value) {
			$prev = date('Y-1-1 0:0:0');
			if($key != 0){
				$prev = $time[$key-1];
			}
			
			$query1 .= "(SELECT COUNT(likes.id) FROM likes JOIN news ON news.id = likes.news_id AND news.author_id = ".$bloggerId." WHERE likes.created < '".$value."' AND likes.created > '".$prev."') ".$months[$key].", ";
			$query2 .= "(SELECT COUNT(comments.id) FROM comments JOIN news ON news.id = comments.news_id AND news.author_id = ".$bloggerId." WHERE comments.created < '".$value."' AND comments.created > '".$prev."') ".$months[$key].", ";
			$query3 .= "(SELECT COUNT(shares.id) FROM shares JOIN news ON news.id = shares.news_id AND news.author_id = ".$bloggerId." WHERE shares.created < '".$value."' AND shares.created > '".$prev."') ".$months[$key].", ";
		}
		$query1 = substr($query1,0,strlen($query1)-2);
		$query2 = substr($query2,0,strlen($query2)-2);
		$query3 = substr($query3,0,strlen($query3)-2);		
		$stmt1 = $this->conn->prepare($query1);
		$stmt2 = $this->conn->prepare($query2);
		$stmt3 = $this->conn->prepare($query3);
		$stmt1->execute();
		$stmt2->execute();
		$stmt3->execute();
		$likes = $stmt1->fetch(PDO::FETCH_ASSOC);
		$comments = $stmt2->fetch(PDO::FETCH_ASSOC);
		$shares = $stmt3->fetch(PDO::FETCH_ASSOC);
		return ['likes' => $likes, 'comments' => $comments, 'shares' => $shares];

	}//end get_news_graph_stat

	function get_news_most_likes_stat($bloggerId, $time){
		if(isset($last)){
			if(trim($last) != 0 && trim($last) != ""){
				$next = " AND ".$this->table.".id < ".$last;
			}
			else $next = "";
		}
		else{
			$next = "";
		}

						
		$query = "SELECT ".$this->table.".id,title,blogger.first_name as author,".$this->table.".created,link,(SELECT COUNT(*) FROM likes WHERE likes.news_id=".$this->table.".id) likes_no FROM ".$this->table." JOIN attachments JOIN users ON users.id=".$bloggerId." JOIN master_categories JOIN sub_categories JOIN blogger WHERE attachments.id=attachment_id AND ".$this->table.".author_id=users.id AND users.unique_id=blogger.id AND master_category_id=master_categories.id AND sub_category_id=sub_categories.id AND news.created > '".$time."' ".$next." ORDER BY likes_no DESC LIMIT 10";	
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		return $stmt->fetchAll();
	}//end get_news_most_likes_stat

	function get_news_most_comments_stat($bloggerId, $time){
		if(isset($last)){
			if(trim($last) != 0 && trim($last) != ""){
				$next = " AND ".$this->table.".id < ".$last;
			}
			else $next = "";
		}
		else{
			$next = "";
		}

						
		$query = "SELECT ".$this->table.".id,title,blogger.first_name as author,".$this->table.".created,link,(SELECT COUNT(*) FROM comments WHERE comments.news_id=".$this->table.".id) comments_no FROM ".$this->table." JOIN attachments JOIN users ON users.id=".$bloggerId." JOIN master_categories JOIN sub_categories JOIN blogger WHERE attachments.id=attachment_id AND ".$this->table.".author_id=users.id AND users.unique_id=blogger.id AND master_category_id=master_categories.id AND sub_category_id=sub_categories.id AND news.created > '".$time."' ".$next." ORDER BY comments_no DESC LIMIT 10";	
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		return $stmt->fetchAll();
	}//end get_news_most_comments_stat

	function get_news_most_shares_stat($bloggerId, $time){
		if(isset($last)){
			if(trim($last) != 0 && trim($last) != ""){
				$next = " AND ".$this->table.".id < ".$last;
			}
			else $next = "";
		}
		else{
			$next = "";
		}

						
		$query = "SELECT ".$this->table.".id,title,blogger.first_name as author,".$this->table.".created,link,(SELECT COUNT(*) FROM shares WHERE shares.news_id=".$this->table.".id) shares_no FROM ".$this->table." JOIN attachments JOIN users ON users.id=".$bloggerId." JOIN master_categories JOIN sub_categories JOIN blogger WHERE attachments.id=attachment_id AND ".$this->table.".author_id=users.id AND users.unique_id=blogger.id AND master_category_id=master_categories.id AND sub_category_id=sub_categories.id AND news.created > '".$time."' ".$next." ORDER BY shares_no DESC LIMIT 10";	
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		return $stmt->fetchAll();
	}//end get_news_most_shares_stat

	function delete_post($postId){
		$query = "SELECT attachment_id AS attach FROM ".$this->table." WHERE id=?";
		$stmt = $this->conn->prepare($query);
		$stmt->execute([$postId]);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$attach = $row['attach'];
		$query = "DELETE FROM attachments WHERE id=?";
		$stmt = $this->conn->prepare($query);
		if($stmt->execute([$attach])){
			$query = "DELETE FROM news WHERE id=?";
			$stmt = $this->conn->prepare($query);
			if($stmt->execute([$postId]))
				return true;
		}
		
	}//end delete_post

	function search_post($search, $bloggerId, $time, $page=''){
		if(isset($page)){
			if(trim($page) != 0 && trim($page) != "" && trim($page) != 1){
				$limit = (($page - 1) * 10);
			}
			else $limit = 0;
		}
		else{
			$limit = 0;
		}
		if(isset($search)){
			$search_query = "";
			foreach ($search as $key => $value) {
				$search_query .= " AND ".$this->table.".".$key." LIKE '%".$value."%'";
			}
		}
		else{
			$search_query = "";
		}
		
				
		$query = "SELECT ".$this->table.".id,title,blogger.first_name as author,".$this->table.".created,link, (SELECT COUNT(*) FROM likes WHERE likes.news_id=".$this->table.".id) likes, (SELECT COUNT(*) FROM comments WHERE comments.news_id=".$this->table.".id) comments, (SELECT COUNT(*) FROM shares WHERE shares.news_id=".$this->table.".id) shares FROM ".$this->table." JOIN attachments JOIN users ON users.id=".$bloggerId." JOIN master_categories JOIN sub_categories JOIN blogger WHERE attachments.id=attachment_id AND ".$this->table.".author_id=users.id AND users.unique_id=blogger.id AND master_category_id=master_categories.id AND sub_category_id=sub_categories.id AND news.created > '".$time."'".$search_query." ORDER BY ".$this->table.".id DESC LIMIT ".$limit.",10";	
		if($query == null) exit(null);
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$temp = $stmt->fetchAll();
		$data['news'] = $temp;
		
		$query = "SELECT COUNT(".$this->table.".id) AS total FROM ".$this->table." JOIN attachments JOIN users ON users.id=".$bloggerId." JOIN master_categories JOIN sub_categories JOIN blogger WHERE attachments.id=attachment_id AND ".$this->table.".author_id=users.id AND users.unique_id=blogger.id AND master_category_id=master_categories.id AND sub_category_id=sub_categories.id AND news.created > '".$time.$time."'".$search_query."";
		$stmt2 = $this->conn->prepare($query);
		$stmt2->execute();
		$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
		$total = $row2['total'];
		if($total % 10 != 0){
			$no_of_pages = ($total/10) + 1;
		}
		else{
			$no_of_pages = ($total/10);
		}
		$no_of_pages = intval($no_of_pages);
		$data['no_of_pages'] = $no_of_pages;
		return $data;
	}//end search_post

	function get_departments($school_id){
		$query = "SELECT department.id,department.name FROM department WHERE department.school_id=?";
		$stmt = $this->conn->prepare($query);
		$exec = $stmt->execute([$school_id]);
		if(!$exec){
			return 'error';
		}
		$temp = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		$data = $stmt->fetchAll();
		return $data;
	}//end get_departments

	function get_programs($department_id){
		$query = "SELECT program.id,program.name FROM program WHERE program.department_id=?";
		$stmt = $this->conn->prepare($query);
		$exec = $stmt->execute([$department_id]);
		if(!$exec){
			return 'error';
		}
		$temp = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		$data = $stmt->fetchAll();
		return $data;
	}//end get_programs

	function get_levels(){
		$query = "SELECT level.id,level.identifier AS name FROM level";
		$stmt = $this->conn->prepare($query);
		$exec = $stmt->execute();
		if(!$exec){
			return 'error';
		}
		$temp = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		$data = $stmt->fetchAll();
		return $data;
	}//end get_levels

	function get_courses($semester){
		$query = "SELECT  course.id AS id course.course_code,course.course_description FROM course WHERE semester=?";
		$stmt = $this->conn->prepare($query);
		$exec = $stmt->execute([$semester]);
		if(!$exec){
			return 'error';
		}
		$temp = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		$data = $stmt->fetchAll();
		return $data;
	}//end get_courses

	function get_grades($semester,$level){
		$query = "SELECT grade.id AS id, course.course_code,course.course_description,grade.point FROM user_courses JOIN grade ON grade.user_courses_id=user_courses.id JOIN course ON course.id=user_courses.course_id WHERE user_courses.semester=? AND user_courses.level_id=?";
		$stmt = $this->conn->prepare($query);
		$exec = $stmt->execute([$semester,$level]);
		if(!$exec){
			return 'error';
		}
		$temp = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		$data = $stmt->fetchAll();
		return $data;
	}//end get_grades

	function store_grades($insertArray){
		$query = "INSERT INTO ".$this->table." VALUES ";
		for($i = 0; $i < sizeof($insertArray); $i++){
			foreach ($insertArray[$i] as $key => $value) {
				$query .= "(null,".$insertArray[$i]['student_course'].",".$insertArray[$i]['point'].",'".$insertArray[$i]['created']."'),";
			}			
		}
		$query = substr($query,0,strlen($query)-1);
		echo $query;
		die();
		$stmt = $this->conn->prepare($query);
		if($stmt->execute()){
			return true;
		}
		else return false;
	}//end store_grades

	function register_course($insertArray){
		$query = "INSERT INTO ".$this->table." VALUES ";
		for($i = 0; $i < sizeof($insertArray); $i++){
			foreach ($insertArray[$i] as $key => $value) {
				$query .= "(null,".$_SESSION['userid'].",".$insertArray[$i]['courseid'].",".$insertArray[$i]['active'].",'".$insertArray[$i]['semester'].",'".$insertArray[$i]['levelid']."'),";
			}			
		}
		$query = substr($query,0,strlen($query)-1);
		echo $query;
		die();
		$stmt = $this->conn->prepare($query);
		if($stmt->execute()){
			return true;
		}
		else return false;
	}//end register_course

	function get_likes($newsid){
		$query = "SELECT ".$this->table.".id,first_name FROM ".$this->table." JOIN users ON users.id=liker JOIN student ON student.id=users.unique_id AND type='student' WHERE ".$this->table.".news_id=".$newsid." UNION SELECT ".$this->table.".id,first_name FROM ".$this->table." JOIN users ON users.id=liker JOIN lecturer ON lecturer.id=users.unique_id AND type='lecturer' WHERE ".$this->table.".news_id=".$newsid." UNION SELECT ".$this->table.".id,first_name FROM ".$this->table." JOIN users ON users.id=liker JOIN mentor ON mentor.id=users.unique_id AND type='mentor' WHERE ".$this->table.".news_id=".$newsid."";
		$stmt = $this->conn->prepare($query);
		$exec = $stmt->execute();
		if(!$exec){
			return 'error';
		}
		$temp = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		$data = $stmt->fetchAll();
		return $data;
	}//end get_likes

	function get_comments($newsid){
		$query = "SELECT ".$this->table.".id,comment,student.first_name FROM ".$this->table." JOIN users ON users.id=commenter JOIN student ON student.id=users.unique_id AND type='student' WHERE ".$this->table.".news_id=".$newsid." UNION SELECT ".$this->table.".id,comment,lecturer.first_name FROM ".$this->table." JOIN users ON users.id=commenter JOIN lecturer ON lecturer.id=users.unique_id AND type='lecturer' WHERE ".$this->table.".news_id=".$newsid." UNION SELECT ".$this->table.".id,comment,mentor.first_name FROM ".$this->table." JOIN users ON users.id=commenter JOIN lecturer ON mentor.id=users.unique_id AND type='mentor' WHERE ".$this->table.".news_id=".$newsid." UNION SELECT ".$this->table.".id,comment,blogger.first_name FROM ".$this->table." JOIN users ON users.id=commenter JOIN blogger ON blogger.id=users.unique_id AND type='blogger' WHERE ".$this->table.".news_id=".$newsid."";
		$stmt = $this->conn->prepare($query);
		$exec = $stmt->execute();
		if(!$exec){
			return 'error';
		}
		$temp = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		$data = $stmt->fetchAll();
		return $data;
	}//end get_comments

	function get_mention($q){
		$query = "SELECT * FROM ".$this->table." WHERE username LIKE '%$q%' ORDER BY id LIMIT 5";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		return $stmt->fetchAll();
	}

	function add_notification($from, $to, $description){
		//$query = "SELECT name FROM";

	}




	


	



}
?>