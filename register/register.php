<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="utf-8">
<head>	
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="Description" Content="有关教师个人信息、教师研究信息、教师活动信息等内容，高校教师的更直接、高集成、全方位、多角度的信息展示平台">
<meta name="description" content="university teacher information display">
<meta name="keywords" content="高校教师,研究信息,社会网络">
<meta name="author" content="Wendell">
<link rel="stylesheet" href="css/register.css" type="text/css" media="all" />
<link rel="stylesheet" href="../css/hf.css" type="text/css" media="all" />
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript"> 
try {
var pageTracker = _gat._getTracker("UA-6403547-1");
pageTracker._trackPageview();
} catch(err) {}</script>
<script type="text/javascript" src="../js/jquery.js"></script>
<script language="javascript" type="text/javascript">
//提交
function brief_submit(){
	//alert("0k");
	if(checkInput())
		$("#info_form").submit();
}
//输入信息检查
function checkInput(){
	//alert("here");
	var name = $("#name").val();
	var univ = $("#univ").val();
	var email = $("#email").val();
	var pass1 = $("#pass1").val();
	var pass2 = $("#pass2").val();
	
	$(".errtip").remove();
	//var namepat = /^[u4e00-u9fa5a-zA-Z]+$/;
	//!namepat.test(name)
	if(name == ""){
		$("#name").after("<span class='errtip'>请输入真实姓名</span>");
		return false;
	}
	if(univ == ""){
		$("#univ").after("<span class='errtip'>请输入完整学校名称</span>");
		return false;
	}
	if(email == ""){
		$("#email").after("<span class='errtip'>请输入密码</span>");
		return false;
	}
	if(pass1 == ""){
		$("#pass1").after("<span class='errtip'>请输入密码</span>");
		return false;
	}
	if(pass2 == ""){
		$("#pass2").after("<span class='errtip'>请重复输入密码</span>");
		return false;
	}
	if(pass2 != pass1){
		$("#pass2").after("<span class='errtip'>两次输入的密码不一致</span>");
		return false;
	}
	
	//alert("here");
	return true;
}
</script>
<title>高校教师人物网——注册页面</title>
</head>

<body>
<div id="wraper">

<!--包含头部-->
<?php include "../include/header.php";?>

<!--主题内容-->
<div id="content">
	<div id="middle">
		<div class="module">
			<div class="title">基本信息</div>	
		
			<div class="info">
			<form id="info_form" class="apply_form" method="post" action="register2.php">
				<p>
					<label for="type">
						<em class="em">*</em>
						类型：
					</label>
					<select id="type" class="select" type="text" name="type">
						<option value="teacher">教师</option>
						<option value="student">学生</option>
					</select>
					<span class="tip_txt">提示：暂时只支持以教师和学生两种身份注册</span>
				</p>
				
				<p>
					<label for="type">
						<em class="em">*</em>
						姓名：
					</label>
					<input id="name" type="text" name="name">
				</p>
				
				<p>
					<label for="univ"><em class="em">* </em>学校：</label>
					<input id="univ" name="univ" type="text">
				</p>
				<p class="sex">
					<span class="f_label"><em class="em">* </em>性别：</span>
					<label for="sex1"><input id="sex1" name="sex" class="radio" value="男" checked="checked" type="radio">男</label>
					<label for="sex2"><input id="sex2" name="sex" class="radio" value="女" type="radio">女</label>
				</p>

				<p class="mail">
					<label for="email"><em class="em">* </em>电子邮箱：</label>
					<input id="email" name="email" type="text">
					<span class="tip_txt">用于登录时的账号</span>
				</p>

				<p style="margin-bottom:0">
					<label for="password"><em class="em">* </em>输入密码：</label>
					<input id="pass1" name="password" type="password">
				</p>
				<p>
					<label for="password"><em class="em">* </em>再次输入密码：</label>
					<input id="pass2" name="password2" type="password">
				</p>
				
				<div class="ctrl" id="after_tips">
					<button type="button" onclick="brief_submit()" class="bt">保存并下一步</button>
					<!--
						<button type="button" class="bt_cancel" onclick="preview_submit(1)">预览</button>
					-->
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
