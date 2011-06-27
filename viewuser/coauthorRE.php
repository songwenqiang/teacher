<?php
session_start();
include_once("../include/const.inc");
include_once("../include/functions.inc");

//正在查看页面的ID
if(!isset($_GET['uid'])){
	jump("../index.php","请选择要查看的用户");
}
$uid = $_GET['uid'];
//利用UID得到TID
$tid = getTIDbyUID($uid);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="utf-8">
<head>	
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="Description" Content="有关教师个人信息、教师研究信息、教师活动信息等内容，高校教师的更直接、高集成、全方位、多角度的信息展示平台">
<meta name="description" content="university teacher information display">
<meta name="keywords" content="高校教师,研究信息,社会网络">
<meta name="author" content="Wendell">
<link rel="stylesheet" href="css/content.css" type="text/css" media="all" />
<link rel="stylesheet" href="../css/hf.css" type="text/css" media="all" />
<title>高校教师人物网——论文合作关系展示</title>

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

	<!--主体内容-->
	<div id="content">
		<div id="left">
			<?PHP include "../include/leftnav.php";?>
		</div>
		
		<div id="middle">
			<div>		
				<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%" id="TeacherRelation">
					<param name="movie" value="../visualRE/TeacherRelation.swf" />
					<param name="quality" value="high" />
					<param name="bgcolor" value="#ffffff" />
					<param name="allowScriptAccess" value="sameDomain" />
					<param name="allowFullScreen" value="true" />
					<param name='flashVars' value="id=<?PHP echo $tid?>" />
					<embed name='TeacherRelation' src='../visualRE/TeacherRelation.swf' height='500' width='600' flashVars="id=<?PHP echo $tid;?>"/>           
				</object>	
			</div>
		</div>  
		
		<!--right-->
		<div id="right">  
		</div>
		
	</div>

<!--底部：版权信息-->
<?php include "../include/footer.php"; ?>

</div>
</body>
</html>
