<?php

require("mainController.php");
class URL extends Instucom{
//properties of the class
private $url;
private $url_bits;
private $url_ok;
private $x;
private $y;
private $z;
private $page_short_code;
private $pages;
private $controller_short_code;
private $controller_link;
private $content;
private $folder;
private $mimeType;



function __construct($url){    
    //set the constants to be used by the class
    $this->page_short_code = __PAGE_SHORT_CODE;
    $this->pages = __PAGES;
    $this->controller_short_code = __CONTROLLER_SHORT_CODE;
    $this->controller_link = __CONTROLLER_LINK;
    $this->x = URI_INDEX;       //set the index of the controller in the url
    $this->y = $this->x + 1;        //set the model to be called
    $this->z = $this->y + 1;  
    $this->mimeType = isset($_GET['mimeType']) ? $_GET['mimeType'] : "json";      
    $this->url = $url;      //setting the url property
    $this->url_check();     //checking if url is valid
    $this->split_url();     //spliting the url into bits
    
}//end __construct

public function url_check(){
    if(trim($this->url) != ""){     //checking if the url is empty
        $this->url_ok = true;
    }
    else $this->url_ok = false;
    
    
}//end url_check

public function split_url(){
    if($this->url_ok){
        $this->url_bits = preg_split("/[\/,]+/",$this->url);        //splitting the url if okay
        $temp = preg_split("/[\?,]+/",$this->url_bits[$this->x]);   //checking for a get data sent through the link
        if(2 >= sizeof($temp)){
            $this->url_bits[$this->x] = $temp[0];       //setting the rest of the result as the link
        }
        //$identifier = strstr($this->url_bits[$this->x],"C");    //checking if the link specifies a controller
        if($this->mimeType == "text/html"){
		$this->folder = "./view/";          //setting render folder as view folder
	    }
        else if(in_array($this->url_bits[$this->x],$this->page_short_code)){
            $this->folder = "./view/";          //setting render folder as view folder
        }
        else $this->folder = "./controller/";       //if view setting render folder as controller folder
        //if a backslash exists at the end of link strip it and load link without backslash
        if(sizeof($this->url_bits) >= 4){
        if(trim($this->url_bits[sizeof($this->url_bits)-1]) == ""){
            header("Location:".substr($this->url,0,strlen($this->url)-1));      
        }
        }
        //print_r($this->url_bits);
    }
    else {
        $this->folder = "./controller/";  //homepage selected;
    }        
    
}//end split_url

public function get_url_bits(){
    return $this->url_bits;    
}//end get_url_bits

public function get_page(){
    if($this->folder == "./view/"){       //check if its a view rendering
    if(in_array($this->url_bits[$this->x],$this->page_short_code)){     //check if shortcode exists
        foreach ($this->page_short_code as $key => $value) {        //get page from shortcode
            if($this->url_bits[$this->x] == $value){
                $this->content = $this->folder.$this->pages[$key];      //saqve the page to be rendered
            }
            else{
                //do nothing
            }
        }
    }//endif
    else if(trim($this->url_bits[$this->x]) == ""){
        $this->content = $this->folder.$this->pages[0]; 
    }
    else{
        foreach ($this->page_short_code as $key => $value) {
            if("404" == $value){
                $this->content = "./view/".$this->pages[$key];        //if page doesnt exist content is set as 404
            }
            else{
                //do nothing
            }
        }
                //$this->content = $this->folder.$this->pages[7];
    }
    }
    else{
        if(in_array($this->url_bits[$this->x],$this->controller_short_code)){       //if controller set the required controller
        foreach ($this->controller_short_code as $key => $value) {
            if($this->url_bits[$this->x] == $value){
                $this->content = $this->folder.$this->controller_link[$key];
            }
            else{
                //do nothing
            }
        }
    }//endif
    else{
        foreach ($this->page_short_code as $key => $value) {
            if("404" == $value){
                $this->content = "./view/".$this->pages[$key];        //if doesn't exist show error page
            }
            else{
                //do nothing
            }
        }
    }
    }
}//end get_page

public function render(){
    if(file_exists($this->content)){
    include($this->content);        //render the content
    }
    else{
        foreach ($this->page_short_code as $key => $value) {
            if("404" == $value){
                $this->content = "./view/".$this->pages[$key];        //if doesn't exist show error page
            }
        }
        include($this->content);        //render the content

    }
}


}

?>