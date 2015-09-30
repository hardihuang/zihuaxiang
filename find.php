<?php 
$pageTitle="发现";
require_once 'includes/header.php';

//list new users from zhx_user
$rows=getRecentUsers(10);

echo('<p class="user_list_title">最新用户：</p><hr>');
echo('<ul class="user_list">');
	foreach($rows as $row){
		echo('<li><a href="viewUser.php?target_uid='.$row['uid'].'"><img  src="images/uploads/avatar_100/'.$row['avatar'].'"><br>'); //show user's avatar
		echo('<span>'.$row['name'].'</span></a></li>');
	}
echo('</ul>');//end user_list ul

//list new posts from zhx_post

$rows1=getRecentPosts(10);
echo('<p  class="user_list_title">最新记录：</p><hr>');
echo('<ul class="post_list_find">');
	foreach($rows1 as $row){
		//get post time
		$postTimeRow=$row['date'];
		$postTime= strtotime($postTimeRow);
		$time=new Mygettime(time(),$postTime);
		$showTime=$time->index();
		//get post like people
		$sql="select zhx_post.pid,zhx_like.uid,lid from zhx_post left join zhx_like on zhx_post.pid=zhx_like.pid where zhx_post.pid={$row['pid']} order by lid desc";
		$like_data=fetchAll($sql);
		$likeNum=getNumByPid($row['pid'],"zhx_like");
		//get post comment
		$sql="select zhx_post.pid,zhx_comment.uid,zhx_comment.cid,zhx_comment.comment,zhx_comment.date from zhx_post left join zhx_comment on zhx_post.pid=zhx_comment.pid where zhx_post.pid={$row['pid']} order by cid desc";
		$comment_data=fetchAll($sql);
		$commentNum=getNumByPid($row['pid'],"zhx_comment");

?>
		<!-- user info	 -->
		<li class="post_row">
			<a class="post_user" href="viewUser.php?target_uid=<?php echo($row['uid']); ?>">
				<span class="post_avatar"><?php echo('<img  src="images/uploads/avatar_50/'.$row['avatar'].'">') ?></span><br>
				<span class="post_name"><?php echo($row['name']) ?></span>
			</a>
<?php
	echo('<ul class="post_content">');

		if($row['image']){
			//判断图片是否大于100% width,若大于则宽度为100%(.full_width)，否则为自身大小
			$image_w=getimagesize("images/uploads/postImage_500/".$row['image'])[0]>330 ? true : false;
			$style="class='full_width'";
?>
			<li class="post">
				<a  href="images/uploads/postImage/<?php echo($row['image'])?>">
					<img <?php if($image_w){echo $style;} ?>   src="images/uploads/postImage_500/<?php echo($row['image'])?>">
				</a>
			</li>
<?php
		}
?>
			<!-- show post text -->
			<li class="post"><?php echo($row['post'])?></li>
			<!-- show post info (date,like button,delete button) -->
			<li class="post_info">
				<span title="<?php echo $postTimeRow ?>"><?php echo $showTime; ?></span>&nbsp;&nbsp;
				<a href="doAction.php?act=likePost&pid=<?php echo $row['pid']; ?>" >赞&nbsp;(<?php echo $likeNum; ?>)</a>&nbsp;&nbsp;
				<a class="show_comment" onclick="showComment(<?php echo $row['pid']; ?>)">评论&nbsp;(<?php echo $commentNum; ?>)</a>&nbsp;&nbsp;
			</li>
			
<?php
				if(($like_data[0]['uid'])){
					echo '<li class="post_like">';
					foreach ($like_data as $like) {
					 	$like_user=getUserByUid($like['uid']);
?>
					
					 	<a href="viewUser.php?target_uid=<?php echo $like_user['uid']; ?>">
							<img title="<?php echo $like_user['name'] ?>" src="images/uploads/avatar_50/<?php echo $like_user['avatar']; ?>">
						</a>
					
<?php
					 }
					 echo '</li>';
				}

				// show comment content
				echo "<div class='comment' id='comment".$row['pid']."'>";
				if(($comment_data[0]['uid'])){
					echo '<li class="post_comment">';
						
					foreach ($comment_data as $comment) {
						echo '<ul class=post_comment_row>';
					 	$comment_user=getUserByUid($comment['uid']);
		?>			
						
						<a class="post_comment_user" href="viewUser.php?target_uid=<?php echo $comment_user['uid']; ?>">
							<span class="post_avatar">
								<img title="<?php echo $comment_user['name'] ?>" src="images/uploads/avatar_50/<?php echo $comment_user['avatar']; ?>">
							</span>
						</a>

						
						<ul class="post_comment_content">
							<li class="post_comment_text"><?php echo $comment['comment'] ?></li>
							<li class="post_comment_info">
								<?php echo substr($comment['date'],5,11) ?>
		<?php 
								if($comment['uid']==$uid){
		?>	
								&nbsp;&nbsp;<a href="doAction.php?act=deleteComment&cid=<?php echo $comment['cid']?>&pid=<?php echo $row['pid'] ?>&comment_uid=<?php echo $comment['uid']?>">&nbsp;&nbsp;删除</a>
		<?php
								}
		 ?>
							</li>
						</ul><!-- end post_comment_content ul-->

		<?php
						echo '</ul>'; // end post_comment_row ul
					 }
						
					echo '</li>'; //end post_comment li
					 
				}

?>
		<!-- comment box -->
		<li class="post_comment_form" >
			<form method="post" action="doAction.php?act=commentPost&pid=<?php echo $row['pid'] ?>">
				<input class="comment_input" type="text" name="comment" placeholder="输入你的评论...">
				<input class="comment_submit" type="submit" value="加上去" name="评论">
			</form>
			<br><br>
		</li>
		</div> <!-- end comment div -->

		</ul><!-- end post_content ul -->
		</li><!-- end post_row -->
		<br>
<?php

	}
?>



<?php 
require_once 'includes/footer.php';
?>
