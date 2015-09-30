<?php 
header("content-type:text/html;charset=utf-8");
date_default_timezone_set("PRC");
session_start();
define("ROOT",dirname(__FILE__));
set_include_path(".".PATH_SEPARATOR.ROOT."/lib".PATH_SEPARATOR.ROOT."/core".PATH_SEPARATOR.get_include_path());
require_once 'configs.php';

require_once 'mysql.func.php';
require_once 'image.func.php';
require_once 'string.func.php';
require_once 'page.func.php';
require_once 'upload.func.php';
require_once 'timeFormate.class.php';


require_once 'comment.inc.php';
require_once 'post.inc.php';
require_once 'user.inc.php';
connect();
