<?php 
$pageTitle="注册";
require_once 'includes/header_b4.php';
 ?>


 <form class="form_b4" method="post" action="doAction.php?act=signup" enctype="multipart/form-data">
 	<label for="name">姓名:</label><br>
 	<input type="text" name="name"><br><br>
 	<label for="password">密码:</label><br>
 	<input type="password" name="password"><br><br>
 	<label for="avatar">头像:<span style="font-size:12px">&nbsp;(1M以内)</span>:</label><br>
 	<input style="width:170px;" type="file" id="avatar" name="avatar" accept="image/jpeg,image/gif,image/jpg,image/png"><br><br>
	<label for="verify">验证码:</label><br>
	<img style="width:100px" src="getVerify.php" id="verify" alt="点击更换验证码" onclick="reverify()"/><br>
	<input type="text" name="verify"><br><br>
	
 	<input class="submit"  type="submit" name="submit" value="注册" >
 </form>


<?php 
require_once 'includes/footer.php';
 ?>

  <!-- click verify pic to change-->
<script>
function reverify(){
	document.getElementById("verify").src ="getVerify.php?"+new Date;
} 
</script>