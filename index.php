<?php
$lifetime = 60*60;
session_set_cookie_params($lifetime);
session_start();

include_once("include/const.inc");
include_once("include/functions.inc");

$displayerr = "none";
//填写信息处理
if(isset($_POST['username']) && $_POST['username'] != ""){
	$name = $_POST['username'];
	$password = $_POST['password'];
	
	$query = "select * from user where email=\"$name\" and password=\"$password\"";
	$result = mysql_query($query) or die(mysql_error());
	if($row=mysql_fetch_array($result)){
		//正确登录
		$_SESSION['uid'] = $row['id'];
		if($row['type'] == "teacher")
			$_SESSION['tid'] = $row['tid'];
		$_SESSION['name'] = $row['name'];
		
		//跳转到用户页面
		jump("viewuser/basicinfo.php?uid=".$row['id']);
	}else{
		//登录失败
		$displayerr = "block";
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="utf-8">
<head>	
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/hf.css" type="text/css" media="all" />
<link rel="stylesheet" href="css/main.css" type="text/css" media="all" />
<title>高校教师人物网</title>
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
<div id='wraper'>
<!--包含头部-->
<?php include "include/header.php";?>

<!--主题内容-->
<div id="content">
	<div style="float:left;width:230px;">
		<div class="login">		
		<div class="panel">
			<div class="errinfo" style="display:<?PHP echo $displayerr;?>">
			用户名或密码输入不正确，请重新输入！
			</div>
			<form id="login" action="register/login.php" method="post">
				<div id="uname" class="fi">
					<label class="lb">账号:</label>
					<input id="id" class="ipt-t" type="text"  name="username" tabindex="1">
					
				</div>
				<span class="tips">注册时输入的邮箱</span>
				<div class="fi">
					<label class="lb">密 码:</label>
					<input id="pwdinput" class="ipt-t" type="password" name="password" tabindex="2">
				</div>
				<div class="fi-nolb">
					<input type="submit" value="登录" class="btn btn-login">
					<a class="btn btn-reg" href="register/register.php">注册</a>
				</div>
			</form>
		</div>
		</div>	
		
	</div>
	
	<!--中间-->
	<div style="margin-left:5px;padding: 20px;float:left;width:576px">
		<div style="width: 700px;" id="r2l">
<div style="margin: 20px 0pt 10px 20px; width: 120px;" class="f14 l"><span style="font: bold 20px '黑体'; color: rgb(208, 30, 59);">高校教师网</span> </div>
<div style="margin: 20px 0pt 30px 60px; line-height: 2em; width: 500px;font-size:14px">高校教师网目前立足于海天园网络知识服务平台IT部落，旨在利用机器学习、数据挖掘及自然语言处理相关研究成果，自动化地构建一个社会化网络。该系统的基本用户群体定位为高校教师（目前限于计算机领域教师），但是向全体互联网用户提供有关教师个人信息、教师研究信息、教师科研活动信息等内容，实现一个有关高校教师的更直接、高集成、全方位、多角度的信息展示平台，并在此基础上打造一个大量科研人员参与的学术交流平台</div>
<div class="c"></div>
<div style="padding-left: 40px;" class="tac mb10"><img width="500" height="108" onload="javascript: v_index_showtoppic = 1;" src="http://it.haitianyuan.com/teacher/image/des.gif"></div>
<div class="tac mt15">&nbsp;
</div>
<div style="margin: 0px 50px 5px 120px;" class="f13">
<div style="margin-top:25px;line-height:19px;font-size:13px" >我们每天都在进步着：</div>
</div>
<div style="margin-top: 10px;">
<div style="margin: 0px 10px 3px 120px; width: 5em;" class="l tar f13 c6">1月17日</div>
<div style="margin: 0pt 50px 3px 0pt; width: 430px;" class="l f13 c6">首页：重新设计了首页页面</div>
<div class="c"></div>
<div style="margin: 0px 10px 3px 120px; width: 5em;" class="l tar f13 c6">1月15日</div>
<div style="margin: 0pt 50px 3px 0pt; width: 430px;" class="l f13 c6">网站收藏：自定义您的导航网页</div>
<div class="c"></div>
<div style="margin: 0px 10px 3px 120px; width: 5em;" class="l tar f13 c6">12月30日</div>
<div style="margin: 0pt 50px 3px 0pt; width: 430px;" class="l f13 c6">论文列表的重新设计</div>
<div class="c"></div>
</div>
<div style="margin-top:50px;padding: 50px 50px 45px 280px; width: 300px; height: 20px;" class="f13">
<a target="_blank" href="http://it.haitianyuan.com/lyb/index.php" class="sl">给我们提意见</a>
</div>

</div>

	</div>
	
</div>

<!--底部：版权信息-->
<?php include "include/footer.php"; ?>
</div>
</body>
</html>
