<?php 
$pageTitle="修改资料";
require_once 'includes/header.php';

$user_data=getUserByUid($uid);
// print_r($user_data);
?>

 


<form class="form_b4" method="post" action="doAction.php?act=changeInfo" enctype="multipart/form-data">
	 <img  src="images/uploads/avatar/<?php echo $user_data['avatar'] ?>" alt=""><br><br>

 	<label for="avatar">更新头像:</label><br>
 	<input style="width:170px;" type="file" id="avatar" name="avatar" accept="image/jpeg,image/gif,image/jpg,image/png"><br><br>
 	<label for="name">更改姓名:</label><br>
 	<input type="text"  value="<?php echo $user_data['name']?>" name="name"><br><br>
 	<i>更改密码</i>
 	<hr>
 	<label for="password">当前密码:</label><br>
 	<input type="password" name="password"><br><br>
 	<label for="passwordNew">新密码:</label><br>
 	<input type="password" name="passwordNew" placeholder="留空则为当前密码"><br><br><br>
 	<hr>
	<br><br>
 	<input class="submit"  type="submit" name="submit" value="更新" >
 	<br>
 	<br>
 	<br>
 </form>

<?php 
require_once 'includes/footer.php';
?>
