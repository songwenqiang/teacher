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
<meta name="keywords" content="高校教师,研究信息,社会网络,基金信息">
<meta name="author" content="Wendell">
<link rel="stylesheet" href="../search/css/foundation.css" type="text/css" media="all" />
<link rel="stylesheet" href="../css/hf.css" type="text/css" media="all" />
<title>高校教师人物网——基金信息</title>

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
//按教师查询
function searchbyteacher(start){	
	
	//教师方式请求查询
	$.post("searchbyteacher.php",
	{
		uid:<?php echo $_GET['uid'];?>,
		start:start
	},
	function(json){
		//alert(json);
		var json = eval(json);
		
		displayresult(start,json,"searchbyteacher");
	}
	);
}
//添加查询结果
//type: searchbyuniv;searchbyteacher;searchbycon
function displayresult(start,data,type){
	//总的结果数
	var totalnum = data[0].totalnum;
	
	
	var con = "<table><tr><th style='width:30px'>序号</th><th style='width:70px'>项目批准号</th><th style='width:60px'>申请代码</th>"+
	    "<th style='width:400px'>项目名称</th><th style='width:50px'>项目负责人</th><th style='width:100px'>依托单位</th>"+
			"<th style='width:30px'>批准金额</th><th style='width:150px'>项目起止</th></tr>";
	for(var i=1;i<data.length;i++){
		con += "<tr><td>"+i+"</td><td>"+data[i].approve_num+"</td><td>"+data[i].apply_num+"</td><td>"+
		      data[i].pname+"</td><td>"+data[i].tname+"</td><td>"+data[i].unit+"</td><td>"+data[i].amount+
			  "</td><td>"+data[i].start+"至"+data[i].end+"</td></tr>";
	}
	con += "</table>";
	var p = displayPageNav(start,totalnum,type);
	$("#uresult").html(con+p);
	
	//显示结果
	$("#result").show();
}

//页面分页显示
function displayPageNav(start,totalnum,func){
	//左侧
	var npage = "<div class='number-proj'>";
	var endnum = 0;

	if(start+pagesize < totalnum){
		endnum = start+pagesize;
	}
	else{
		endnum = totalnum;
	}
	npage += "第"+(start+1)+"-"+endnum+"项/共"+totalnum+"项</div>";
	
	//右侧
	var pagepanel = "<div id=\"pageTopPanel\" class=\"float-right\"><ol class=\"pagerpro\">";
	var currpage = 0;
	if(totalnum>0){
		currpage = start/pagesize+1;
		if(start%pagesize == 0)
			currpage = currpage-1;
		
		//上一页
		if(start-pagesize >=0)
			pagepanel += "<li><a onclick='"+func+"("+(start-pagesize)+")'>上一页</a></li>";
			
		//打印页面链接
		var pripagenum = 5;	//当前页前面显示5页
		var pagelinknum = 10;	//总共显示11个页面链接
		var startindex = 0;
		var p = 1;
		if(start > pripagenum*pagesize){
			startindex = start - pripagenum*pagesize;
			p = currpage-pripagenum;
		}
		for(var i=startindex,j=0;i<totalnum && j<pagelinknum;i = i+pagesize,j++){
			if(i == start)
				pagepanel += "<li class='current'><a onclick='"+func+"("+i+")'>"+p+"</a></li>";
			else
				pagepanel += "<li><a onclick='"+func+"("+i+")'>"+p+"</a></li>";	
				
			p++;
		}
		//打印下一页链接
		if(start+pagesize < totalnum){
			var ns = start+pagesize;
			pagepanel += "<li><a onclick='"+func+"("+ns+")'>下一页</a></li>";
		}
	}
	pagepanel += "</ol></div>";

	//返回分页导航页面内容
	return "<div class=\"pagenav\">"+npage+pagepanel+"</div>";
}

//每页显示的项目数
var pagesize=40;

//执行
$(document).ready(function(){
	searchbyteacher(0);
});
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
			<div id="result">
				<div class="module">
						<div class="top">
							<div class="rCorner"></div>
						</div>
						
						<div class="con" id="uresult">
						
							<!--页面导航-->
							
						</div>
			
						<div class="bottom">
							<div class="rCorner"></div>
						</div>
				</div>
			</div>
		</div>
	</div>
<!--底部：版权信息-->
<?php include "../include/footer.php"; ?>

</div>
</body>
</html>