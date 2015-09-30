<?php
require_once 'include.php';
checkLogin();
$avatar=getUserByUid($_SESSION['uid'])['avatar'];
$uid=$_SESSION['uid'];
$notify_num=getNotifyNumByuid($uid);
?>
<!DOCTYPE HTML>

<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta http-equiv="x-ua-compatible" content="ie=7" />
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
	<title><?php echo $pageTitle; ?>－自画像</title>
	<link rel="stylesheet" href="styles/style.css">
	<script src="scripts/jquery.js"></script>
	<script src="scripts/notifyRedirect.js"></script>
</head>
<body>

<header>
	<div class="logo">
		<a class="logo_image" href="user.php"><h1>自画像</h1></a>
		<a class="logo_menu" href="find.php">发现</a>
		<a class="logo_menu" href="notify.php">消息
		<span class="notify_count <?php if($notify_num==0){echo "hide";}?>"><?php echo $notify_num ?></span>
		</a>
	</div>
	
	<div class="info">
		<?php 

		echo('<a href="changeInfo.php"><img  src="images/uploads/avatar_50/'.$avatar.'"></a>'); //show user's avatar
		echo('<a class="info_name" style="color:white;"href="user.php">' . $_SESSION['name'] . '</a><a class="info_logout" href="doAction.php?act=logout">退出</a>');

		 ?>
	</div>

</header>
<div class="wrap">
