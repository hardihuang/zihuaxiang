<?php 
function showPage($page,$totalPage,$who=null,$sep="&nbsp;"){
	$who=($who==null)?null:"&target_uid=".$who;
	$url = $_SERVER ['PHP_SELF'];
	$index = ($page == 1) ? "<span class='pager_btn'>首页</span>" : "<a href='{$url}?page=1{$who}'><span class='pager_btn'>首页</span></a>";
	$last = ($page == $totalPage) ? "<span class='pager_btn'>尾页</span>" : "<a href='{$url}?page={$totalPage}{$who}'><span class='pager_btn'>尾页</span></a>";
	$prevPage=($page>=1)?$page-1:1;
	@$nextPage=($Page>=$totalPage)?$totalPage:$page+1;
	$prev = ($page == 1) ? "<span class='pager_btn_nav'>&nbsp;&nbsp;&lt;&nbsp;&nbsp;</span>" : "<a href='{$url}?page={$prevPage}{$who}'><span class='pager_btn_nav'>&nbsp;&nbsp;&lt;&nbsp;&nbsp;</span></a>";
	$next = ($page == $totalPage) ? "<span class='pager_btn_nav'>&nbsp;&nbsp;&gt;&nbsp;&nbsp;</span>" : "<a href='{$url}?page={$nextPage}{$who}'><span class='pager_btn_nav'>&nbsp;&nbsp;&gt;&nbsp;&nbsp;</span></a>";
	$str = "总共{$totalPage}页/当前是第{$page}页";
	for($i = 1; $i <= $totalPage; $i ++) {
		//当前页无连接
		if ($page == $i) {
	@		$p .= "<span class='pager_btn pager_btn_on'>&nbsp;{$i}&nbsp;</span>";
		} else {
	@		$p .= "<a href='{$url}?page={$i}{$who}'><span class='pager_btn'>&nbsp;{$i}&nbsp;</span></a>";
		}
	}
 	$pageStr=$sep . $index .$sep. $prev.$sep . @$p.$sep . $next.$sep . $last;
 	return $pageStr;
}
 ?>