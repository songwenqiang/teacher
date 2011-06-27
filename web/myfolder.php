<?php
session_start();
include_once("../include/const.inc");
include_once("../include/functions.inc");
if(!isset($_GET['uid']))
	Header("Location:$BASEURL/index.php");
//正在查看的页面的用户ID	
$uid = $_GET['uid'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="utf-8">
<head>	
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="Description" Content="有关教师个人信息、教师研究信息、教师活动信息等内容，高校教师的更直接、高集成、全方位、多角度的信息展示平台">
<meta name="description" content="university teacher information display">
<meta name="keywords" content="高校教师,研究信息,社会网络">
<meta name="author" content="Wendell">
<link rel="stylesheet" href="css/web.css" type="text/css" media="all" />
<link rel="stylesheet" href="../css/hf.css" type="text/css" media="all" />
<title>高校教师人物网——网址类别管理</title>

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
<script type="text/javascript" language="javascript">
function addcate(){
	var name = $("#catename").val();
	//提交新的类别
	$.post("catectrl.php",
	{
		operation:"add",
		name: name
	},
	function(res){
		//alert(res);
		
		if(res == "notlogin"){
			alert("您还未登录，请登录后执行该操作！");
		}
		else if(res == "failed"){
			alert("添加类别出错，请稍后再试！");
		}
		else{
			var data = eval("("+res+")");
			var num = Number($(".num:last").text());
			
			if(num == null)
				num = 0;
			num = num+1;
			var newcate = "<li id='"+data.id+"'><div class='num'>"+num+"</div><div class='catecon'>"+
				"<div id='name"+data.id+"'class='catename'>"+data.name+"</div><div class='urlnum'>0</div><div class='createdate'>"+
				data.time+"</div><div class='edit'><a onclick='editcate("+data.id+")'>编辑</a><a>删除</a></div></div></li>";
			$("#catelist").append(newcate);
		}
	}
	);
}
//编辑类别

function editcate(cid){
	//输入新的类别名
	var name=prompt("请输入新的类别名");
	if(name == null || name == "")
		return;
	
	//提交新的类别
	$.post("catectrl.php",
	{
		operation:"edit",
		cid:cid,
		name: name
	},
	function(res){
		
		if(res == "notlogin"){
			alert("您还未登录，请登录后执行该操作！");
		}
		else if(res == "failed"){
			alert("添加类别出错，请稍后再试！");
		}
		else{
			$("#name"+cid).text(name);
			
		}
	}
	);
}
//删除类别
function delcate(cid){
	
	if(!confirm("确定要删除该类别及所属的所有网址吗"))
		return;
		
	//删除类别
	$.post("catectrl.php",
	{
		operation:"delete",
		cid:cid
	},
	function(res){
		
		if(res == "notlogin"){
			alert("您还未登录，请登录后执行该操作！");
		}
		else if(res == "failed"){
			alert("添加类别出错，请稍后再试！");
		}
		else{
			$("#"+cid).remove();
			
		}
	}
	);
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
			<div class="tabnav">
				<ul>
					<li><a href=<?PHP echo "'myweb.php?uid=$uid'";?>>我的收藏</a></li>
					<li><a href=<?PHP echo "'addweb.php?uid=$uid'";?>>添加收藏</a></li>
					<li id="active"><a href=<?PHP echo "'myfolder.php?uid=$uid'";?>>类别管理</a></li>
				</ul>
			</div>
			
			<div class="infobar">
			</div>
			
			<!--当前已有类别-->
			<div id="cate">
			<ul id='catelist'>
			<?PHP
				$query = "select * from web_folder where uid=$uid";
				$result = mysql_query($query) or die(mysql_error());
				$i=0;
				while($row=mysql_fetch_array($result)){
					$i++;
					$name = $row['name'];
					$time = $row['time'];
					$num = $row['num'];
					$id= $row['id'];
					
					echo "<li id='$id'>";
					echo "<div class='num'>$i</div>";
					echo "<div id='name$id' class='catename'>$name</div>";
					
					echo "<div class='urlnum'>$num</div>";
					echo "<div class='createdate'>$time</div>";
					echo "<div class='edit'><a onclick='editcate($id)'>编辑</a>-<a onclick='delcate($id)'>删除</a></div>";
					echo "</li>";
				}
				if($i == 0){
					echo "当前内容中还没有类别，请添加新的类别";
				}
			?>
			</ul>
			</div>
			
			<!--添加新的类别-->
			<div id="addcate">
				<label>添加新的类别：</label><input id='catename' type="text" name='catename' />
				<button type="button" onclick="addcate()" class='bt'>添加</button>
			</div>
		
		</div>
		<div id="right">
		</div>
	</div>

<!--底部：版权信息-->
<?php include "../include/footer.php"; ?>

</div>
</body>
</html>