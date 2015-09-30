<?php 
$pageTitle="登录";
require_once 'includes/header_b4.php';
 ?>

<div class="wrap">
 <form class="form_b4" method="post" action="doAction.php?act=login">
 	<label for="name">姓名:</label><br>
 	<input type="text" name="name"><br><br>
 	<label for="password">密码:</label><br>
 	<input type="password" name="password"><br><br>
 	<input class="submit" type="submit" name="submit" value="登录" >
 </form>
</div>

<?php 
require_once 'includes/footer.php';
 ?>