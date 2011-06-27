<?php
session_start();
include_once("../include/const.inc");
include_once("../include/functions.inc");

if(!isset($_GET['uid']))
	Header("Location:$BASEURL/index.php");
//正在查看的页面的用户ID	
$uid = $_GET['uid'];

//是否登陆
if(!isset($_SESSION['uid']))
	jump("$BASEURL/register/login.php","您还没有登录，请登录后执行该操作！");
//登陆用户ID和查看用户ID是否一致
$userid = $_SESSION['uid'];
if($uid != $userid)
	jump("$BASEURL/viewpaper/addpaper.php?uid=$userid","您无权在别人的页面做此操作，系统已跳回您的页面！");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="utf-8">
<head>	
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="Description" Content="有关教师个人信息、教师研究信息、教师活动信息等内容，高校教师的更直接、高集成、全方位、多角度的信息展示平台">
<meta name="description" content="university teacher information display">
<meta name="keywords" content="高校教师,研究信息,论文">
<meta name="author" content="Wendell">
<link rel="stylesheet" href="css/paper.css" type="text/css" media="all" />
<link rel="stylesheet" href="../css/hf.css" type="text/css" media="all" />
<title>高校教师人物网——添加论文</title>

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
<script type="text/javascript">
//显示标签页
function showmenu(num){
	for(var i=1;i<=3;i++){
		$("#m"+i).attr("class","on");
		$("#c"+i).hide();
	}
	$("#m"+num).attr("class","off");
	$("#c"+num).show();
}

//提交
function submit1(){
	$("#form1").submit();
}
function submit2(){
	$("#form2").submit();
}
</script>
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
			<div class="tabmenu">
				<ul>
					
					<li id="m1" onclick="showmenu(1)" class="off">输入方式</li>
					<li id="m2" onclick="showmenu(2)" class="on">导入方式</li>
					<li id="m3" onclick="showmenu(3)" class="on">参考文献方式</li>
				</ul>
			</div>
			<div class="tabcontent">
				<!--输入方式添加新的论文-->
				<div id="c1">
					&nbsp;
					<form id="form1" class="apply_form" method="post" action="addctrl1.php">
						<div class="inb">
							<label for="ptype"><em class="em">* </em>类型：</label>
							<select name="ptype">
								<option value="none">请输入</option>
								<option value="conference">会议论文</option>
								<option value="journal">期刊论文</option>
								<option value="thesis">毕业论文</option>
								<option value="book">书籍</option>
								<option value="other">其他</option>
							</select>
						</div>
						
						<div class="inb">
							<label for="pname"><em class="em">* </em>标题：</label>
							<input type="text" name="pname" />
						</div>
						<div class="inb">
							<label for="author"><em class="em">* </em>作者：</label>
							<input type="text" name="author" />
							<span class="tip_txt">
								如有多个作者请以“，”分隔，并按作者顺序输入
							</span>
						</div>
						<div class="inb">
							<label for="name"><em class="em"></em>期刊(会议)名：</label>
							<input type="text" name="name" />
						</div>
						<div class="inb">
							<label for="volume"><em class="em"></em>卷：</label>
							<input type="text" name="volume" />
						</div>
						<div class="inb">
							<label for="num"><em class="em"></em>期：</label>
							<input type="text" name="num" />
						</div>
						<div class="inb">
							<label for="page"><em class="em"></em>页数：</label>
							<input type="text" name="page">
							<span class="tip_txt">
								格式：××-××
							</span>
						</div>
						<div class="inb">
							<label for="year"><em class="em">* </em>年份：</label>
							<input type="text" name="year">
						</div>
						<div class="inb">
							<label for="refurl"><em class="em"></em>在线参考地址：</label>
							<input type="text" name="refurl">
							<span class="tip_txt">
								网上有关该论文的介绍的URL地址
							</span>
						</div>
						<div class="inb">
							<label for="keyword"><em class="em"></em>论文关键词：</label>
							<input type="text" name="keyword" />
							<span class="tip_txt">
								多个关键词请以“，”分隔
							</span>
						</div>
						<div class="inb">
							<label for="abstract"><em class="em"></em>论文摘要：</label>
							<textarea id="abstract" cols="50" rows="5" name="abstract"></textarea>
						</div>
						<div class="ctrl" id="after_tips">
							<button type="button" onclick="submit1()" class="bt">保存信息</button>
						</div>
					</form>
				</div>
				<!--输入方式添加新的论文-->
				<div id="c2" style="display:none">
					&nbsp;
					<form id="form2" class="apply-form" method="post" action="addctrl2.php">
					<div class="fcon">
						<div class="b-left">
							<div class="b-title">
								请输入要添加论文的ENDNOTE信息（可以输入多个论文的信息，依次输入即可）：
							</div>
							<div class="b-content">
								<textarea id="endnote" cols="30" rows="10" name="endnote"></textarea>
							</div>
							<div class="ctrl">
								<button type="button" onclick="submit2()" class="bt">导入论文</button>
							</div>
						</div>
						<div class="b-example">
							<p>ENDNOTE格式定义实例说明:</p>
							<p style="margin-left:30px">
								%0 Journal Article (类型：期刊文章)<br />
								%T 文档聚类综述 （标题）<br />%A 刘远超 （作者）<br />
								%A 王晓龙 （作者）<br />%A 徐志明 （作者）<br />%A 关毅（作者）<br />
								%J 中文信息学报（期刊名）<br />
								%V 20 （期号）<br />
								%N 003 （卷号）<br />
								%P 55-62 （页数）<br />
								%D 2006	（年份）<br />
							</p>
							<p>请输入以上形式的ENDNOTE格式信息，系统会自动解析并添加相应内容</p>
						</div>
					</div>	
					<form>
				</div>
				<!--参考文献方式添加新的论文-->
				<div id="c3" style="display:none">
					&nbsp;
					<form id="form3" class="apply-form" method="post" action="addctrl3.php">
						<div class="formcont">
							<div class="b-title">
								请输入要添加论文的参考文献格式信息：
							</div>
							<div class="b-content">
								<textarea id="refinfo" cols="50" rows="10" name="refinfo"></textarea>
							</div>
							<div class="ctrl">
								<button type="button" onclick="brief_submit()" class="bt">导入论文（该方法暂不支持）</button>
							</div>
						</div>
					<form>
				</div>
			</div>
		</div>
		
	</div>

<!--底部：版权信息-->
<?php include "../include/footer.php"; ?>

</div>
</body>
</html>