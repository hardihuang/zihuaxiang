<?php 
/**
 * 检测是否登陆.
 */
function checkLogin(){
	if(!( isset($_SESSION['uid']) && isset($_SESSION['name']) )){
		alertMsg('请先登录','login.php');
		return false;
	}else{
		return true;
	}
}

function loginRedirect(){
	if(!( isset($_SESSION['uid']) && isset($_SESSION['name']) )){
		if (isset($_COOKIE['uid']) && isset($_COOKIE['name'])) {
			$_SESSION['uid'] = $_COOKIE['uid'];
			$_SESSION['name'] = $_COOKIE['name'];
			echo("<meta http-equiv='refresh' content='0;url=user.php'/>");
		}
	}else{
		echo("<meta http-equiv='refresh' content='0;url=user.php'/>");
	}
}

function login(){
	@$name=$_POST['name'];
	//addslashes():使用反斜线引用特殊字符
	//$username=addslashes($username);
	$name=mysql_escape_string($name);
	$password=md5($_POST['password']);
	$sql="select * from zhx_user where name='{$name}' and password='{$password}'";
	//$resNum=getResultNum($sql);
	$row=fetchOne($sql);
	//echo $resNum;
	if($row){
		$_SESSION['uid']=$row['uid'];
		$_SESSION['name']=$row['name'];
		setcookie('uid',$row['uid'],time()+3600*24*7);
		setcookie('name',$row['name'],time()+3600*24*7);
		$mes="嗨 ".$_SESSION['name']." ,欢迎回来！<br/>2秒钟后跳转到你的个人页面<meta http-equiv='refresh' content='2;url=user.php'/>";
		// $mes="嗨 ".$_SESSION['name']." ,欢迎回来！";
	}else{
		$mes="╮(╯_╰)╭ &nbsp;&nbsp;登陆失败！<meta http-equiv='refresh' content='1;url=login.php'/>";
		// $mes="登陆失败！";
	}
	return $mes;
}

function checkNameExist($name){
	$sql="select name from zhx_user where name='$name'";
	$out = fetchOne($sql) ? true : false;
	return $out;
}

function signup(){
	$arr=$_POST;
	$arr['password']=md5($_POST['password']);
	$arr['regTime']=date("Y-m-j"." "."H:i:s");//匹配数据库中的datetime时间格式
	$verify1=$_SESSION['verify'];
	if(empty($arr['name']) || empty($arr['password'])  || empty($arr['verify'])) {
		$msg= "请将信息填写完整!<meta http-equiv='refresh' content='1;url=signup.php'/>";
		return $msg;
		exit;
	}
	if($arr['verify']!=$verify1){
		$msg="验证码错误<meta http-equiv='refresh' content='1;url=signup.php'/>";
		return $msg;
		exit;
	}
	if(checkNameExist($arr['name'])){
		$msg="用户已存在，请更换用户名<meta http-equiv='refresh' content='1;url=signup.php'/>";
		return $msg;
		exit;
	}
	$uploadFile=uploadFile('images/uploads/avatar/');
	array_splice($arr, 2, 2); //删除数组中注册不需要用到的submit和verify元素
	//print_r($uploadFile);
	if($uploadFile&&is_array($uploadFile)){
		$arr['avatar']=$uploadFile[0]['name'];
	}else{
		return "注册失败<meta http-equiv='refresh' content='1;url=signup.php'/>";
	}
	// print_r($arr);exit;

	if(insert("zhx_user", $arr)){
		thumb("images/uploads/avatar/".$uploadFile[0]['name'],"images/uploads/avatar_50/".$uploadFile[0]['name'],50,50);
		thumb("images/uploads/avatar/".$uploadFile[0]['name'],"images/uploads/avatar_100/".$uploadFile[0]['name'],100,100);
		$msg="注册成功!<br/>2秒钟后跳转到登陆页面!<meta http-equiv='refresh' content='2;url=login.php'/>";
	}else{
		$filename="images/uploads/avatar/".$uploadFile[0]['name'];
		if(file_exists($filename)){
			unlink($filename);
		}
		$msg="注册失败!<meta http-equiv='refresh' content='1;url=signup.php'/>";
	}
	return $msg;
}

function logout(){
	$_SESSION=array();
	if (isset($_COOKIE["uid"])){
		setcookie("uid",NULL,time()-3600*24*7);
		setcookie("name",NULL,time()-3600*24*7);
	}
	session_unset();
	session_destroy();
	header("location:index.php");

}

function changeInfo(){
	$arr=$_POST;
	$uid=$_SESSION['uid'];
	$where="uid=$uid";
	unset($arr['submit']); 
	// return print_r($arr);

	//判断是否输入新的用户名，若是则检查是否已被注册，否则将name从$arr中去掉
	if($arr['name']===$_SESSION['name']){
		unset($arr['name']);
	}else{
		$newName=$arr['name'];
		if(checkNameExist($newName)){
			$msg="姓名为 ".$newName." 的用户已存在，请更换用户名后再试<meta http-equiv='refresh' content='2;url=changeInfo.php'/>";
			return $msg;
			exit;
		}

	}

	//判断是否输入新密码，若是则检查旧密码是否正确，否则将password和passwordNew从$arr中去掉
	if( !empty($arr['passwordNew'])  ) {
		$oldPassword=md5($arr['password']);
		$sql="select * from zhx_user where name='{$_SESSION['name']}' and password='{$oldPassword}'";
		$row=fetchOne($sql);
		if(!$row){
			$msg="原密码输入错误！<meta http-equiv='refresh' content='1;url=changeInfo.php'/>";
			return $msg;
		}else{
			$arr['password']=md5($arr['passwordNew']);
			unset($arr['passwordNew']); 
		}
		
	}else{
		unset($arr['password']); 
		unset($arr['passwordNew']); 
	}

	if(!empty($_FILES['avatar']['name'])){
		$uploadFile=uploadFile('images/uploads/avatar/');
		if($uploadFile&&is_array($uploadFile)){
			$arr['avatar']=$uploadFile[0]['name'];
			thumb("images/uploads/avatar/".$uploadFile[0]['name'],"images/uploads/avatar_50/".$uploadFile[0]['name'],50,50);
			thumb("images/uploads/avatar/".$uploadFile[0]['name'],"images/uploads/avatar_100/".$uploadFile[0]['name'],100,100);

			// delete old avatar
			$oldAvatar=getUserByUid($uid)['avatar'];
			$filename="images/uploads/avatar/".$oldAvatar;
			if(file_exists($filename)){
				unlink($filename);
			}
			$filename1="images/uploads/avatar_50/".$oldAvatar;
			if(file_exists($filename1)){
				unlink($filename1);
			}
			$filename2="images/uploads/avatar_100/".$oldAvatar;
			if(file_exists($filename2)){
				unlink($filename2);
			}
		}else{
			$msg= "上传头像失败，请稍后再试<meta http-equiv='refresh' content='1;url=changeInfo.php'/>";
			$filename="images/uploads/avatar/".$uploadFile[0]['name'];
			if(file_exists($filename)){
				unlink($filename);
			}
		}
	}
	// return print_r($arr);
	if(empty($arr)){
		$msg="你没有做任何修改哦！<meta http-equiv='refresh' content='1;url=changeInfo.php'/>";
		return $msg;
	}
	if(update("zhx_user", $arr,$where)){
		$msg="信息更新成功!<meta http-equiv='refresh' content='2;url=user.php'/>";

		if(@$arr['name']){
			$_SESSION['name']=$arr['name'];
			setcookie('name',$arr['name'],time()+3600*24*7);
		}
		
	}else{
		$msg="信息更新失败!<meta http-equiv='refresh' content='1;url=changeInfo.php'/>";
	}
	return $msg;
}

function deleteUser(){
	if($_SESSION['uid']!='1'){
		$msg="权限不足,无法删除用户!<meta http-equiv='refresh' content='1;url=user.php'/>";
		return $msg;
	} 
	$uid=$_REQUEST['uid'];
	if($uid==1){
		$msg="管理员无法被删除！";
		return $msg;
	}
	
	
	// delete user avatar
	$row=getUserByUid($uid);
	$filename="images/uploads/avatar/".$row['avatar'];
	if(file_exists($filename)){
		unlink($filename);
	}
	$filename="images/uploads/avatar_50/".$row['avatar'];
	if(file_exists($filename)){
		unlink($filename);
	}
	$filename="images/uploads/avatar_100/".$row['avatar'];
	if(file_exists($filename)){
		unlink($filename);
	}

	//delete user postImage
	$sql="select zhx_album.pid,image,iid from zhx_post right join zhx_album on zhx_post.pid=zhx_album.pid where zhx_post.uid=$uid";
	$rows=fetchAll($sql);
	if($rows){
		foreach ($rows as $row) {
			$filename="images/uploads/postImage/".$row['image'];
			if(file_exists($filename)){
				unlink($filename);
			}
			$filename="images/uploads/postImage_500/".$row['image'];
			if(file_exists($filename)){
				unlink($filename);
			}
			delete("zhx_album","iid=".$row['iid']);
		}	
	}
	

	//delete  user notify in and out
	$where="uid=".$uid." or nuid=".$uid;
	delete("zhx_notify",$where);

	//delete user like in and out
	delete("zhx_like","uid=".$uid);
	$sql='select lid from zhx_post right join zhx_like on zhx_post.pid=zhx_like.pid where zhx_post.uid='.$uid;
	$rows=fetchAll($sql);
	if($rows){
		foreach ($rows as $row) {
			delete('zhx_like','lid='.$row['lid']);
		}
	}

	//delete user comment in and out
	delete("zhx_comment","uid=".$uid);
	$sql='select cid from zhx_post right join zhx_comment on zhx_post.pid=zhx_comment.pid where zhx_post.uid='.$uid;
	$rows=fetchAll($sql);
	if($rows){
		foreach ($rows as $row) {
			delete('zhx_comment','cid='.$row['cid']);
		}
	}

	// delete user posts
	delete("zhx_post","uid=".$uid);

	//delete user account
	delete("zhx_user","uid=".$uid);

	$msg="用户删除成功！<meta http-equiv='refresh' content='1;url=admin.php'/>";
	return $msg;
}

function getUserByUid($uid){
	$sql="select * from zhx_user where uid=$uid";
	$row=fetchOne($sql);
	return $row;
}

function getRecentUsers($limit){
	$sql="select uid,name,avatar from zhx_user order by regTime desc limit $limit";
	$rows=fetchAll($sql);
	return $rows;
}
 
 function getAllUsers(){
 	$sql="select * from zhx_user order by regTime desc";
 	$rows=fetchAll($sql);
 	return $rows;
 }

 function countNum($table,$where){
 	$sql="select count(*) from {$table} where {$where}";
 	$res=fetchOne($sql);
 	return $res;
 }

