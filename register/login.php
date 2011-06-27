<?php
$lifetime = 60*60;
session_set_cookie_params($lifetime);
session_start();

include_once("../include/const.inc");
include_once("../include/functions.inc");

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
		jump("../viewuser/basicinfo.php?uid=".$row['id']);
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
<meta name="Description" Content="有关教师个人信息、教师研究信息、教师活动信息等内容，高校教师的更直接、高集成、全方位、多角度的信息展示平台">
<meta name="description" content="university teacher information display">
<meta name="keywords" content="高校教师,研究信息,社会网络">
<meta name="author" content="Wendell">
<link rel="stylesheet" href="css/login.css" type="text/css" media="all" />
<link rel="stylesheet" href="../css/hf.css" type="text/css" media="all" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script language="javascript" type="text/javascript">
</script>
<title>高校教师人物网——登录页面</title>
</head>

<body>
<div id="wraper">

<!--包含头部-->
<?php include "../include/header.php";?>

<!--主题内容-->
<div id="content">
	<div id="middle">
		<div class="login">
		
		<div class="panel">
			<div class="errinfo" style="display:<?PHP echo $displayerr;?>">
			用户名或密码输入不正确，请重新输入！
			</div>
			<form id="login" action="login.php" method="post">
				<div id="uname" class="fi">
					<label class="lb">用户名</label>
					<input id="id" class="ipt-t" type="text"  name="username" tabindex="1">
					<span class="tips">注册时输入的邮箱</span>
				</div>
				<div class="fi">
					<label class="lb">密 码</label>
					<input id="pwdinput" class="ipt-t" type="password" name="password" tabindex="2">
				</div>
				<div class="fi-nolb">
					<input type="submit" value="登录" class="btn btn-login">
					<a class="btn btn-reg" href="register.php">注册</a>
				</div>
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
