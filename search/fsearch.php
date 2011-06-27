<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="utf-8">
<head>	
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="Description" Content="有关教师个人信息、教师研究信息、教师活动信息等内容，高校教师的更直接、高集成、全方位、多角度的信息展示平台">
<meta name="description" content="university teacher information display">
<meta name="keywords" content="自然科学基金，查询">
<meta name="author" content="Wendell">
<link rel="stylesheet" href="css/foundation.css" type="text/css" media="all" />
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
/**搜索导航标签页显示控制*/
function show_tabmenu(id,tab_num,totalnum){
	for(var i=0;i<totalnum;i++){
      document.getElementById(id+"_tabmenu_"+i).className="normalmenu";
      document.getElementById(id+"_tabcontent_"+i).style.display="none";
   }
   document.getElementById(id+"_tabmenu_"+tab_num).className="currentmenu";
   document.getElementById(id+"_tabcontent_"+tab_num).style.display="block";
}

//清空内容
function cleaninput(id){
	$("#"+id).attr("value","");
}

//按学校查询
function searchbyuniv(start){	
	//检查输入
	var uname = $("#uname").attr("value");
	uname = uname.replace(/(^\s*)|(\s*$)/g, ""); 
	if(uname == null || uname==""){
		alert("请输入学校名称");
		return;
	}
	
	//年份
	var year = $("#year").val();
	//alert(uname+year);
	//查询前动画消失之前结果
	//$("#result").fadeOut("normal");
	
	//学校方式请求查询
	$.post("foundationsearch/searchbyuniv.php",
	{
		uname:uname,
		year:year,
		start:start
	},
	function(json){
		//alert(json);
		var json = eval(json);
		
		displayresult(start,json,"searchbyuniv");
	}
	);
}
//按教师查询
function searchbyteacher(start){	
	//检查输入
	var tname = $("#tname").attr("value");
	var tuniv = $("#tuniv").attr("value");
	tname = tname.replace(/(^\s*)|(\s*$)/g, ""); 
	if(tname == null || tname==""){
		alert("请输入教师姓名");
		return;
	}
	tuniv = tuniv.replace(/(^\s*)|(\s*$)/g, ""); 
	if(tuniv == null || tuniv == ""){
		tuniv="";
	}
	
	//查询前动画消失之前结果
	//$("#result").fadeOut("normal");
	
	//教师方式请求查询
	$.post("foundationsearch/searchbyteacher.php",
	{
		tname:tname,
		tuniv:tuniv,
		start:start
	},
	function(json){
		//alert(json);
		var json = eval(json);
		
		displayresult(start,json,"searchbyteacher");
	}
	);
}
//按内容查询
function searchbycon(start){	
	//检查输入
	var keyword = $("#keyword").attr("value");
	var cuniv = $("#tuniv").attr("value");
	keyword = keyword.replace(/(^\s*)|(\s*$)/g, ""); 
	if(keyword == null || keyword==""){
		alert("请输入项目名关键词");
		return;
	}
	//年份
	var year = $("#cyear").val();
	
	//查询前动画消失之前结果
	//$("#result").fadeOut("normal");
	//alert(keyword+year);
	//教师方式请求查询
	$.post("foundationsearch/searchbycon.php",
	{
		keyword:keyword,
		year:year,
		start:start
	},
	function(json){
		//alert(json);
		var json = eval(json);
		
		displayresult(start,json,"searchbycon");
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

</script>
<title>高校教师人物网——基金搜索</title>
</head>

<body>
<div id="wraper">

<!--包含头部-->
<?php include "../include/header.php";?>

<!--主题内容-->
<div id="content">
<div id="middle">

	<div class="search">			
		<div class="tabmenu">
			<ul>
				<li id="s_tabmenu_0" class="currentmenu" onclick="show_tabmenu('s',0,3)">学校查询</li>
				<li id="s_tabmenu_1" class="normalmenu" onclick="show_tabmenu('s',1,3)">教师查询</li>
				<li id="s_tabmenu_2" class="normalmenu" onclick="show_tabmenu('s',2,3)">内容查询</li>
			</ul>
		</div>
		<div class="tabcontent">
			<!--学校查询-->
			<div id="s_tabcontent_0">
				学校<input id="uname"  type="text" onclick="cleaninput('uname');">
				<select id="year" name="year">
					<?php
						$year = date("Y");
						$year = intval($year);
						echo "<option value='all'>全部</option>";
						for(;$year>1997;$year=$year-1){
							echo "<option value='".$year."'>$year</option>";
						}
					?>
				</select>
				<input type="submit" value="查询" onclick="searchbyuniv(0)">
			</div>
			<!--教师查询-->
			<div id="s_tabcontent_1" style="display:none">
				姓名<input id="tname" type="text" onclick="cleaninput('tname');">
				学校<input id="tuniv" type="text">
				<input type="submit" value="查询" onclick="searchbyteacher(0)">
			</div>
			<!--按基金内容查询-->
			<div id="s_tabcontent_2" style="display:none">
				关键词<input id="keyword" type="text" onclick="cleaninput('keyword');">
				<select id="cyear" name="cyear">
					<?php
						$year = date("Y");
						$year = intval($year);
						echo "<option value='all'>全部</option>";
						for(;$year>1997;$year=$year-1){
							echo "<option value='".$year."'>$year</option>";
						}
					?>
				</select>
				<input type="submit" value="查询" onclick="searchbycon(0)">
			</div>
		</div>			
	</div>
	
	<div id="result">
		<div class="module">
				<div class="top">
					<div class="rCorner"></div>
				</div>
				
				<div class="con" id="uresult">
					<!--说明提示信息-->
					<div class="desc">
						<P>我们收集了近10年来的自然科学基金项目信息，供从事科学研究的国内学者使用！
						</p><p>查询方式包括如下三种：</p>
						<ul>
							<li>1.按学校查询：在输入框中输入学校完整名称，并选择查询年份（默认为当前年份）
							    。如有相应的基金项目，页面将显示对应的结果。分页显示，每页40项。</li>
							<li>2.按教师查询：在输入框中输入教师名称、学校完整名称（可选），
							    点击查询。如有相应的基金项目，页面将显示对应的结果。分页显示，每页40项。</li>
							<li>3.按项目名称查询：在输入框中输入该项目名中包含的关键词（多个关键词以空格分隔），并选择查询年份（默认为当前年份）
							    。如有相应的基金项目，页面将显示对应的结果。分页显示，每页40项。</li>
						</ul>
						<p>本页面使用了AJAX展示方式，使你具有更好的体验！如您需要更多查询方式，请联系我们！</p>
					</div>
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
