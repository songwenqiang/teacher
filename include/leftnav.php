<?php 
/***导航信息***/
$nav_page = array(
				array("basicinfo.php","morebasicinfo.php"),
				array("basicpaperinfo.php","detailpaperinfo.php"),
				array("coauthorRE.php","departRE.php"),
				array("editbasicinfo.php"),
				array("../wiki/editwiki.php")
		);

$nav_info = array(
				array("概况介绍","详细介绍"),
				array("论文概况","论文详细"),
				array("合作论文","单位关系"),
				array("编辑信息"),
				array("用户编辑")
			);			
?>

<div class="navbox">
	<div class='title'>个人信息</div>
		<ul>
			<?php 
				echo "<li><a href='".$BASEURL."/viewuser/basicinfo.php?uid=".$uid."'>概况介绍</a></li>";
				echo "<li><a href='".$BASEURL."/viewuser/morepersonalinfo.php?uid=".$uid."'>详细信息</a></li>";
				if(isset($_SESSION['uid']) && $_SESSION['uid'] == $uid){
					echo "<li><a href='".$BASEURL."/viewuser/editbasicinfo.php?uid=".$uid."'>我要编辑</a></li>";
				}
			?>
		</ul>
</div>

<div class="navbox">
	<div class="title">研究相关</div>
	<ul>
		<?php 
			echo "<li><a href='".$BASEURL."/viewuser/basicpaperinfo.php?uid=".$uid."'>论文概况</a></li>";
			echo "<li><a href='".$BASEURL."/viewpaper/truepaperlist.php?uid=".$uid."'>论文列表</a></li>";
			echo "<li><a href='".$BASEURL."/viewfoundation/foundation.php?uid=".$uid."'>基金列表</a></li>";
			//如果是登陆用户，而且当前浏览页面属于该登陆用户，则显示编辑
			if(isset($_SESSION['uid']) && $_SESSION['uid'] == $uid){
				echo "<li><a href='".$BASEURL."/viewpaper/addpaper.php?uid=".$uid."'>添加论文</a></li>";
			}
		?>
	</ul>
</div>

<div class="navbox">
	<div class="title">关系展示</div>
	<ul>
		<?php 
			echo "<li><a href='".$BASEURL."/viewuser/coauthorRE.php?uid=".$uid."'>合作关系</a></li>";
			//echo "<li><a href='".$BASEURL."/viewuser/departRE.php?uid=".$uid."'>单位关系</a></li>";
		?>
	</ul>
</div>

<div class="navbox">
	<div class="title">用户编辑</div>
	<ul>
		<?php 
			echo "<li><a href='".$BASEURL."/wiki/viewwiki.php?uid=".$uid."'>查看信息</a></li>";
			echo "<li><a href='".$BASEURL."/wiki/editwiki.php?uid=".$uid."'>我来编辑</a></li>";
		?>
	</ul>
</div>

<div class="navbox">
	<div class="title">网址收藏</div>
	<ul>
		<?php 
			echo "<li><a href='".$BASEURL."/web/myweb.php?uid=".$uid."'>网址收藏</a></li>";
			//echo "<li><a href='".$BASEURL."/web/my.php?uid=".$uid."'>美文分享</a></li>";
		?>
	</ul>
</div>

<!--搜索框-->
<div class="searchbox">
	<div class="title">搜索</div>
	<form action="../search/searchdisplay.php" method="get">
			<input id="search" size="17" name="keyword" type="text">
	</form>
</div>

   


