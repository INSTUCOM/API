<?php
$stat = (isset($_REQUEST['stat'])) ? $_REQUEST['stat'] : null;
$bloggerId = (isset($_REQUEST['blogger_id'])) ? $_REQUEST['blogger_id'] : null;
$last = (isset($_REQUEST['last'])) ? $_REQUEST['last'] : null;
$time = (isset($_REQUEST['time'])) ? $_REQUEST['time'] : date('Y-1-1 0:0:0');
$page = (isset($_REQUEST['page'])) ? $_REQUEST['page'] : null;
$search = (isset($_REQUEST['search'])) ? json_decode($_REQUEST['search'],true) : null;
require('bloggersController.php');
$blogger = new Bloggers($bloggerId);
switch($stat){
    case 'tab-stat':
        echo json_encode($blogger->get_news_tab_stat($time));    
        die();     
    break;

    case 'all':
    echo json_encode($blogger->get_all_news($time,$page));
    //echo $blogger->get_all_news($time,$page);
    die();
    break;

    case 'search':
    echo json_encode($blogger->get_search_news($search,$time,$page));
    //echo $blogger->get_search_news($search,$time,$page);
    die();
    break;

    case 'graph-stat':
    echo json_encode($blogger->get_news_graph_stat($time));
    die();  
    break;

    case 'most-likes-stat':
    echo json_encode($blogger->get_news_most_stat('likes', $time));
    die();  
    break;

    case 'most-comments-stat':
    echo json_encode($blogger->get_news_most_stat('comments', $time));
    die();  
    break;

    case 'most-shares-stat':
    echo json_encode($blogger->get_news_most_stat('shares', $time));
    die();  
    break;

    default:
    break;
}





?>