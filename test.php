<?php 
require_once 'include.php';

$dir="ftp/images/uploads/postImage/";
$file=scandir($dir);
// print_r($file);exit;
unset($file[0]);
unset($file[1]);
foreach ($file as $image) {
thumb("ftp/images/uploads/postImage/".$image,"ftp/images/uploads/postImage_500/".$image,500);
}
?>
