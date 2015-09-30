<?php 
/**
 * 添加记录
 * @return string
 */
function post(){
	if(getPostNumByUid($_SESSION['uid']) >= maxPost){
		$msg="你的记录总数达到上限 (".maxPost."条)，已不能继续发布记录. <br>若有疑问请联系管理员：huang_hao521@163.com";
		return $msg;
	}
	$arr=$_POST;
	array_splice($arr, 1, 1); //删除数组中注册不需要用到的submit和verify元素
	$arr['date']=date("Y-m-j"." "."H:i:s");//匹配数据库中的datetime时间格式
	$arr['uid']=$_SESSION['uid'];
	// 判断是否有记录图片都没有
	if(empty($arr['post'])  && empty($_FILES['postImage']['name'])){
		$msg="填写内容或添加图片后再添加!<meta http-equiv='refresh' content='1;url=user.php'/>";
		return $msg;
		exit;
	}
	
	$res=insert("zhx_post",$arr);
	if($res){
		$pmsg="记录发布成功！";
	}
	$pid=getInsertId();//获取记录pid用来插入图片
	// return print_r($arr);

	//若有图片添加，则上传图片
	if(!empty($_FILES['postImage']['name'])){
		// print_r($uploadFile);exit;
		$uploadFile=uploadFile("images/uploads/postImage/");
		if($uploadFile&&is_array($uploadFile)){
			$album['image']=$uploadFile[0]['name'];
			thumb("images/uploads/postImage/".$album['image'],"images/uploads/postImage_500/".$album['image'],500);
			$album['pid']=$pid;
			insert("zhx_album",$album);
			$imsg = "添加图片成功!";
		}else{
			$imsg = "添加图片失败!";
		}
	}

	$msg=$pmsg." ".@$imsg."<meta http-equiv='refresh' content='1;url=user.php'/>";
	return $msg;
}

function deletePost(){
	$uid=$_SESSION['uid'];
	@$pid=$_REQUEST['pid'];
	@$iid=$_REQUEST['iid'];
	@$image=$_REQUEST['image'];
	$allow=false;

	$sql="select pid from zhx_post where uid=$uid"; //only the user itself can delete it post, so find witch post is belong to it
	$rows=fetchAll($sql);
	// print_r($rows);exit;
	foreach(@$rows as $row){
		if($pid==$row['pid']){
			$allow=true;
		}
	}
	if(!$allow){
		$msg="你无权删除他人记录！<meta http-equiv='refresh' content='1;url=user.php'/>";
		return $msg;
	}
	$res=delete("zhx_post","pid=$pid");
	if($iid){
		$res1=delete("zhx_album","iid=$iid");
		if(file_exists("images/uploads/postImage/$image")){
			unlink("images/uploads/postImage/$image");
		}
		if(file_exists("images/uploads/postImage_500/$image")){
			unlink("images/uploads/postImage_500/$image");
		}
	}
	$msg=$res ? "记录删除成功!<meta http-equiv='refresh' content='1;url=user.php'/>" : "记录删除失败!<meta http-equiv='refresh' content='1;url=user.php'/>";
	return $msg;
}

function likePost(){
	$arr=$_REQUEST;
	$arr['uid']=$_SESSION['uid'];
	$liked=checkLiked($arr['uid'],$arr['pid']);
	$url=$_SERVER['HTTP_REFERER'];//拿到来时的页面连接,操作完成后再跳转回去
	// 如果之前已经赞过，则取消赞
	if($liked>0){
		delete("zhx_like","uid={$arr['uid']} and pid={$arr['pid']}");
		delete("zhx_notify","uid={$arr['uid']} and pid={$arr['pid']} and type='like'");
		return $msg="你已取消了对这条记录的赞<meta http-equiv='refresh' content='1;url=".$url."'/>";
	}
	// 如果之前没有赞过，则添加赞
	array_splice($arr, 0, 1); //删除数组中不需要用到的元素
	$res=insert("zhx_like",$arr);

	//提醒该用户又新赞
	$notify['uid']=$arr['uid'];
	$notify['nuid']=getUidByPid($arr['pid']);
	$notify['pid']=$arr['pid'];
	$notify['type']='like';
	$res1=insert('zhx_notify',$notify);

	if($res){
		return $msg="点赞成功！<meta http-equiv='refresh' content='1;url=".$url."'/>";
	}else{
		return $msg="操作失败！<meta http-equiv='refresh' content='1;url=".$url."'/>";
	}

}

function commentPost(){
	if(getCommentNum($_SESSION['uid']) >= maxComment){
		$msg="你的评论总数达到上限 (".maxComment."条)，已不能继续发布记录. <br>若有疑问请联系管理员：huang_hao521@163.com";
		return $msg;
	}
	$arr=$_POST;
	$arr['uid']=$_SESSION['uid'];
	$arr['pid']=$_REQUEST['pid'];
	$arr['date']=date("Y-m-j"." "."H:i:s");//匹配数据库中的datetime时间格式
	array_splice($arr, 1, 1); //删除数组中不需要用到的元素
	$url=$_SERVER['HTTP_REFERER'];//拿到来时的页面连接,操作完成后再跳转回去
	// return print_r($arr);
	// 判断是否有评论内容
	if(empty($arr['comment'])){
		$msg="请填写评论内容后再提交!<meta http-equiv='refresh' content='1;url=".$url."'/>";
		return $msg;
		exit;
	}
	
	$res=insert("zhx_comment",$arr);

	//提醒该用户又新评论
	$notify['uid']=$arr['uid'];
	$notify['nuid']=getUidByPid($arr['pid']);
	$notify['pid']=$arr['pid'];
	$notify['type']='comment';
	$res1=insert('zhx_notify',$notify);

	if($res){
		$msg="评论发布成功！<meta http-equiv='refresh' content='1;url=".$url."'/>";
	}
	return $msg;

}

function deleteComment(){

	$uid=$_SESSION['uid'];
	$comment_uid=$_REQUEST['comment_uid'];
	$pid=$_REQUEST['pid'];
	@$cid=$_REQUEST['cid'];
	$url=$_SERVER['HTTP_REFERER'];//拿到来时的页面连接,操作完成后再跳转回去

	if($comment_uid==$uid){
		$res=delete("zhx_comment","cid=$cid");
		delete("zhx_notify","uid=$uid and pid=$pid and type='comment'");
		$msg=$res ? "评论删除成功!<meta http-equiv='refresh' content='1;url=".$url."'/>" : "评论删除失败!<meta http-equiv='refresh' content='1;url=".$url."'/>";
		return $msg;
	}else{
		$msg="你无权删除他人评论！<meta http-equiv='refresh' content='1;url=".$url."'/>";
		return $msg;
	}

}

function markAllRead(){
	$nuid=$_SESSION['uid'];
	$arr['readed']='1';
	$where="nuid=".$nuid;
	$res=update("zhx_notify",$arr,$where);
	if($res){
		$msg="操作成功!<meta http-equiv='refresh' content='0;url=user.php'/>";
		return $msg;
	}else{
		return "操作失败";
	}
}

function getCommentNum($uid){
	$sql="select count(*) from zhx_comment where uid=$uid ";
	$count=fetchOne($sql);
	return $count['count(*)'];
}

function readNotify(){
	$nid=$_REQUEST['nid'];
	$uid=$_SESSION['uid'];
	$cid=$_REQUEST['commentId'];
	$arr['readed']="1";
	$where="nid=".$nid;
	$page=getPageNumByPid($uid,$cid);
	update("zhx_notify",$arr,$where);
	$msg="<meta http-equiv='refresh' content='0;url=user.php?page=".$page."&commentId=".$cid."'/>";
	return $msg;
}

function getNumByPid($pid,$table){
	$sql="select count(*) from {$table} where pid={$pid}";
	$row=fetchOne($sql);
	return $row['count(*)'];
}


function getNotifyNumByuid($uid){
	$sql="select count(*) from zhx_notify where nuid={$uid} and readed='0'";
	$row=fetchOne($sql);
	return $row['count(*)'];
}

function getLikeNumByuid($uid){
	$sql="select count(lid) from zhx_like left join zhx_post on zhx_post.pid=zhx_like.pid where zhx_post.uid=$uid";
	$row=fetchOne($sql);
	return $row['count(lid)'] ;
}

function getUidByPid($pid){
	$sql="select uid from zhx_post where pid={$pid}";
	$row=fetchOne($sql)['uid'];
	return $row;
}

function checkLiked($uid,$pid){
	$sql="select count(*) from zhx_like where pid={$pid} and uid={$uid}";
	$row=fetchOne($sql);
	return $row['count(*)'];
}


function getUserNotifys($uid,$limit){
	$sql="select * from zhx_notify where nuid=$uid order by date desc limit $limit";
	$rows=fetchAll($sql);
	return $rows;
}

function getPostNumByUid($uid){
	$sql="select pid from zhx_post where uid=$uid";
	return getResultNum($sql);
}

function getPostBypid($pid){
	$sql="select * from zhx_post where pid=$pid";
	$row=fetchOne($sql);
	return $row;
}

/**
 * 根据uid得到所有posts
 * @param int $id
 * @return array
 */
function getUserPosts($uid,$offset,$pageSize){
	$sql="select zhx_post.pid,iid,post,date,image from zhx_post left join zhx_album on zhx_post.pid=zhx_album.pid where uid=$uid order by date desc limit {$offset},{$pageSize}";
	$rows=fetchAll($sql);
	return $rows;
}

function getRecentPosts($limit){
	$sql="select zhx_user.name,zhx_user.uid,avatar,zhx_post.pid,iid,post,date,image from zhx_post left join zhx_album on zhx_post.pid=zhx_album.pid left join zhx_user on zhx_post.uid=zhx_user.uid order by date desc limit $limit";
	$rows=fetchAll($sql);
	return $rows;
}

//自己写的function,根据传入的pid判断该记录在第几页，提供给notify的连接用
function getPageNumByPid($uid,$pid){
	$sql="select pid from zhx_post where uid=$uid order by date desc";
	$rows=fetchAll($sql);

	$i=0;
	$n=0;
	foreach ($rows as $row) {
		if($i%pageSize==0){
			$n++;
			// echo $n." ".$i." and ".$row['pid']."<br>";
			if($row['pid']<$pid){
				return $n-1;
			}

		}
		$i++;
	}return $n;
}
