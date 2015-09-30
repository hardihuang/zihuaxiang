<?php 
require_once 'include.php';
$act=$_REQUEST['act'];
if($act==='deleteUser'){
	$msg=deleteUser();
}

 ?>
 <!DOCTYPE HTML>
 <html>
 <head>
 <meta charset="utf-8">
 <meta name="description" content="">
 <meta name="keywords" content="">
 <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
 <meta http-equiv="x-ua-compatible" content="ie=7" />
 <title>do Action - <?php echo $act; ?></title>
 </head>
 <body>
 <?php 
if(@$msg){
	echo $msg;
}
?>
 </body>
 </html>
 