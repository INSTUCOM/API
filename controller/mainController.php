<?php
/**
* Author: Deewaiinc
* Created: 2015-02-01 9:50:23
* Last Updated: 
* Description: The main controller class to be used with the model
* written by deewai inc
* Consists of methods for basic actions of a web application.
* Can be integrated into any web application using the framework(MVC) created by deewai inc.
*/

include dirname(__FILE__)."./../model/index.php";

define("PRESENT_URL", $_SERVER['REQUEST_URI']);
define("HOST", $_SERVER['HTTP_HOST']);
class Instucom
{
	private $model;
	private $data;
    private $item;
    private $cat;
    private $table;

	function __construct($table)
	{
		$this->data = array();
        $this->table = $table;
		$this->model = $this->model_instance();    
	}

    function model_instance(){
        return new Instucom_model($this->table);
    }//end model_instance

    public function get_model(){
        return $this->model;
    }

    function add($data){
        if($this->model->insert_into_table($data)){
        return true;
        }
    }//end add

    function get_terms_id(){
        $ids = $this->model->get_terms_ids();
        $last_index = sizeof($ids) - 1;
        $last_id = $ids[$last_index];
        return $last_id;
        
    }//end get_terms_id

    function login($shop_name, $password){
        return $this->model->login($shop_name,$password);
    }//end login

    function getlink($id){
        return $this->model->get_attachment($id);
    }//end getlink

    function reg($data){
        if($this->model->reg($data)){
            return true;
        }
        else return false;
    }//end reg

    function set($device_id,$status){
        return $this->model->set($device_id,$status);
    }//end set

    function get_data($options){
        return $this->model->get_data($options);
    }

    function get_news($id){
        return $this->model->get_news($id);
    }

    function like_post($post_id){
        return $this->model->like_post($post_id);
    }
    function comment_on_post($insertArray){
        return $this->model->insert_into_table($insertArray);
    }

    function get_dept_level_id($department,$level){
        return $this->model->get_dept_level_id($department,$level);
    }






}


?>