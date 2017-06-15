<?php

define("__SERVER", "localhost");
define("__USER", "root");
define("__PASS", "");
define("__DBNAME", "instucom");
define("__SERVER_ROOT", "http://localhost/API/");
define("URI_INDEX","2");
define("__PAGE_SHORT_CODE", array("default","password","lock","404","500","new-post"));
define("__PAGES", array("default.php","page-password.php","page-lock.php","page-404.php","page-500.php","new_post.php"));
define("__CONTROLLER_SHORT_CODE", array("registerController","signinController","newslist","news","like","comment","logoutController","unlockController","attachment","get-events","store-events","getCategories",'test','blogger-news-details','post-delete','autocomplete','get-grades','save-grades','get-like','get-comment','mention'));
define("__CONTROLLER_LINK", array("registerController.php","signinController.php","get_newsController.php","newsController.php","likeController.php","commentController.php","logoutController.php","unlockController.php","attachmentController.php","getEventsController.php","storeEventsController.php","getCategoriesController.php",'testController.php','bloggerNewsDetails.php','postDeleteController.php','autocompleteController.php','getGradesController.php','saveGradesController.php','getLikeController.php','getCommentController.php','mentionController.php'));
define('ABSPATH', dirname(__FILE__) . '/');
define('TITLE','INSTUCOM');
define('APP_PATH','http://localhost/instucom/app/');


?>
