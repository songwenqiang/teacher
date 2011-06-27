<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="utf-8">
<head>	
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="Description" Content="有关教师个人信息、教师研究信息、教师活动信息等内容，高校教师的更直接、高集成、全方位、多角度的信息展示平台">
<meta name="description" content="university teacher information display">
<meta name="keywords" content="高校教师,搜索">
<meta name="author" content="Wendell">
<link rel="stylesheet" href="css/content.css" type="text/css" media="all" />
<link rel="stylesheet" href="../css/hf.css" type="text/css" media="all" />
<title>高校教师人物网——搜索</title>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript"> 
try {
var pageTracker = _gat._getTracker("UA-6403547-1");
pageTracker._trackPageview();
} catch(err) {}</script>
</head>

<body>
<div id="wraper">

<!--包含头部-->
<?php include "../include/header.php";?>

<!--主题内容-->
<div id="content">
	<div id="middle">		
		<div class="search">		
			<div class="searchtitle">搜索教师</div>
			<div class="searchcontent">
				<form method="get" action="searchdisplay.php">
				<table>
					<tr><td style="padding-right:20px">姓名</td><td><input class="s_input" type="text" name="name"></td><td rowspan=2 style="padding-left:20px;">
						<input type="submit" value="搜索" style="text-align:center;height:30px;width: 50px"></td></tr>
					<tr><td style="padding-right:20px">学校</td><td><input class="s_input" type="text" name="university"></td></tr>
				</table>
				</form>
			</div>
		</div>
	</div>
	
</div>

<!--底部：版权信息-->
<?php include "../include/footer.php"; ?>

</div>
</body>
</html>
