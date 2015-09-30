<?php 
$pageTitle="个人中心";
require_once 'includes/header.php';

if($uid!=1){
	echo "<p style='padding-top:20px;font-size:15px'>权限不足，无法访问本页面</p><meta http-equiv='refresh' content='1;url=user.php'/>";
	exit;
}

$rows=getAllUsers();

echo '<table class="admin_table">';
echo '<tr><th>uid</th><th>名字</th><th>记录数</th><th>消息数</th><th>注册时间</th><th>操作</th></tr>';
foreach($rows as $row){
	$postsCount=getPostNumByUid($row['uid']);
	$notifyCount=countNum("zhx_notify","nuid=".$row['uid']."")['count(*)'];

	// display the the page
	echo '<tr"><td>' . $row['uid'] . '</td>';
	echo '<td><strong><a href="viewUser.php?target_uid='.$row['uid'].'">' . $row['name'] . '</a></strong></td>';
	echo '<td>' . $postsCount . '</td>';
	echo '<td>' . $notifyCount . '</td>';
	echo '<td>' . substr($row['regTime'],0,10) . '</td>';
	if ($row['uid'] != 1) { //check if the user is superamdin
		echo '<td><a href="#" onclick="deleteUser('.$row['uid'].')">删除</a>';
	}else{
		echo '<td><i>管理员</i>';	//super admin can not be deleted!
	}
	echo '</td></tr>';

}
echo '</table>';

require_once 'includes/footer.php';
?>
<script>	
	function deleteUser(uid){ //conform popup
		if(window.confirm("您确定要删除该用户吗？用户账户，所发过的所有记录以及他的头像图片都将会被销毁,删除之后不可以恢复哦！！！")){
			window.location="doAdminAction.php?act=deleteUser&uid="+uid;
		}
	}
</script>
