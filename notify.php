<?php 
$pageTitle="消息";
require_once 'includes/header.php';
$rows=getUserNotifys($uid,10);

echo '<ul class="notify_list">';
echo '<li>'.$notify_num.'&nbsp;条未读';
if($notify_num>0){
	echo '&nbsp;&nbsp;&frasl;&nbsp;&nbsp;<a href="doAction.php?act=markAllRead" style="text-decoration: none">全部标记为已读</a>';
}
echo '</li>';
if($rows){
	foreach ($rows as $row) {
	$row['name']=getUserByUid($row['uid'])['name'];
	// $row['post_name']=substr(getPostBypid($row['pid'])['post'],0,10);
	$row['post_name']=getPostBypid($row['pid'])['post'];
?>
	<li class="notify_row <?php if($row['readed']=="0"){ echo "notify_active";} ?>">
		
<?php 
		if($row['uid']==$row['nuid']){
?>
			<span>
			你
<?php 
				if($row['type']=="like"){
					echo "非常高调的 赞了";
				}else{
					echo "评论了";
				}
 ?>
			自己的记录
			<a href="doAction.php?act=readNotify&nid=<?php echo $row['nid']; ?>&commentId=<?php echo $row['pid'] ?>"><?php  if(!empty($row['post_name'])){echo mb_substr($row['post_name'],0,15,'utf-8')."...";}else{echo "图片";} ?></a>
			</span>
<?php

		}else{


?>

		<span>
			<a href="viewUser.php?target_uid=<?php echo $row['uid'] ?>"><?php echo $row['name']?></a>
<?php 
			if($row['type']=="like"){
				echo "赞了";
			}else{
				echo "评论了";
			}
 ?>
			你的记录
			<a href="doAction.php?act=readNotify&nid=<?php echo $row['nid']; ?>&commentId=<?php echo $row['pid'] ?>"><?php  if(!empty($row['post_name'])){echo mb_substr($row['post_name'],0,15,'utf-8')."...";}else{echo "图片";} ?></a>
		</span>
<?php 
		}
?>
		<br>
		<span class="notify_date"><?php echo $row['date'] ?></span>
			
	</li>
<?php
	}
}else{
	echo "<i>这里空空的耶～～</i>";
}

echo '</ul>'; //end notify_list ul
?>



<?php
require_once 'includes/footer.php';
?>