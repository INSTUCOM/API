<?php

/**
 * 
 */
class Bloggers extends Instucom
{
    private $bloggerId;
    
    function __construct($bloggerId)
    {
        $this->bloggerId = $bloggerId;
        Instucom::__construct('news');
        
    }

    function get_all_news($time,$page=''){        
        return Instucom::get_model()->get_blogger_news($this->bloggerId,$time = date('2017-01-01 0:0:0'),$page);
    }

    function get_search_news($search,$time,$page=''){        
        return Instucom::get_model()->search_post($search,$this->bloggerId,$time = date('2017-01-01 0:0:0'),$page);
    }

    function get_news_tab_stat($time){
        return Instucom::get_model()->get_news_tab_stat($this->bloggerId,$time);
    }

    function get_news_graph_stat($time){
        $intervals = array();
        $i = 1;
        while(date_diff(new DateTime($time), new DateTime('NOW'))->m != 0){
            $time = date('Y-'.$i.'-31 23:59:59');
            $intervals[] = $time;
            $i++;            
        }
        $intervals[] = date('Y-'.$i.'-31 23:59:59');
        return Instucom::get_model()->get_news_graph_stat($this->bloggerId,$intervals);

    }

    function get_news_most_stat($stat,$time){
        switch($stat){
            case 'likes':
                return Instucom::get_model()->get_news_most_likes_stat($this->bloggerId,$time);
            break;

            case 'comments':
                return Instucom::get_model()->get_news_most_comments_stat($this->bloggerId,$time);
            break;

            case 'shares':
                return Instucom::get_model()->get_news_most_shares_stat($this->bloggerId,$time);
            break;

            default:
                return Instucom::get_model()->get_news_most_likes_stat($this->bloggerId,$time);
            break;
        }
        
    }

}


?>