<?php

/**
 * 
 */
const DEPARTMENT_LEVEL = 1;
const FACULTY_LEVEL = 2;
const SCHOOL_LEVEL = 3;
const INSTUCOM_LEVEL = 4;
class Promotons
{
    private $maincontroller;
    
    function __construct()
    {
        $this->maincontroller = new Instucom("users");
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function user_rel($author_id){
        $author = $this->maincontroller->get_model()->get_dept_fac_sch($author_id);
        $loggedin = $this->maincontroller->get_model()->get_dept_fac_sch($_SESSION["userid"]);
        if($loggedin['school_id'] == $author['school_id']){
            return true;
        }
        else{
            if($loggedin['school_id'] == $author['school_id']);
        }

    }




}




?>