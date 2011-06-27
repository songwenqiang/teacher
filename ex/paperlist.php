<?php
session_start();
include_once("../include/const.inc");
include_once("../include/functions.inc");

$tid = $_GET['tid'];
/* //正在查看页面的ID
if(!isset($_GET['uid'])){
	jump("../index.php","请选择要查看的用户");
}
$uid = $_GET['uid'];
//利用UID得到TID
$tid = getTIDbyUID($uid);

//每页显示的论文数目
$pagesize = 30;
$totalnum = getTotalPaperNum($uid,$tid,"right");
//起始
$start = 0;
if(isset($_GET['start'])){
	if($_GET['start'] >=0 && $_GET['start'] < $totalnum){
		$start = $_GET['start'];
	}
} */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="utf-8">
<head>	
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="Description" Content="有关教师个人信息、教师研究信息、教师活动信息等内容，高校教师的更直接、高集成、全方位、多角度的信息展示平台">
<meta name="description" content="university teacher information display">
<meta name="keywords" content="高校教师,研究信息,社会网络">
<meta name="author" content="Wendell">
<link rel="stylesheet" href="css/paperlist.css" type="text/css" media="all" />
<link rel="stylesheet" href="../css/hf.css" type="text/css" media="all" />
<title>高校教师人物网——论文列表</title>
<style type="text/css">
.nouse{
cursor:pointer;
	color: black;
	font-weight: bold;
}
.use{
cursor:pointer;
	color: blue;
	font-weight: bold;
}
.right{
cursor:pointer;
	color: green;
	font-weight: bold;
}
.notright{
	cursor:pointer;
	color: red;
	font-weight: bold;
}
table td{
	margin:4px 0;
	border-bottom: 1px solid #777;
}
</style>
<script type="text/javascript" src="../js/jquery.js"></script>
<script language="javascript">
//预览论文信息
function getPaperPreview(pid){
	//alert(pid);
	$.post("paperpreview.php",
		{
			pid:pid
		},
		function(json){
			//alert(json);
			var json = eval("("+json+")");
			setPreview(json);
		}
	);
}
//设置预览显示
function setPreview(data){
	var preview = $("#prv_mod");
	var p_title = $("#p_title");
	var p_content = $("#p_content");
	
	if(data.volume == "null")
		data.volume = "&nbsp;";
	if(data.num == "")
		data.num = "&nbsp;";
	else 
	    data.num = "("+data.num+")";
	if(data.abstract == "null")
		data.abstract = "&nbsp;";
	if(data.keyword == "null")
		data.keyword = "&nbsp;";
	var content="<p style='line-height:150%;margin:0 10px 10px 0;text-indent:2em;'>"+data.abstract+"</p>"+
				"<dt>作者信息：</dt><dd>"+data.author+"&nbsp;</dd>"+
			//	"<dt>年份：</dt><dd>"++"</dd>"+
				"<dt>期刊（会议）名：</dt><dd>"+data.name+"&nbsp;</dd>"+
			//	"<dt>英文刊名：</dt><dd>"+data.enjournal+"&nbsp;</dd>"+
				"<dt>年，卷(期)：</dt><dd>"+data.date+"&nbsp;"+data.volume+data.num+"</dd>"+
				"<dt>页数：</dt><dd>"+data.page+"&nbsp;</dd>"+
				"<dt>关键词：</dt><dd>"+data.keyword+"&nbsp;</dd>"+
				"<dt>参考链接：</dt><dd>"+data.refurl+"&nbsp;</dd>";
	//alert(content);
	p_content.html(content);
	p_title.empty();
	p_title.append(data.title+"<a style='margin-left:50px;cursor:pointer' onclick='removePreview()' >关闭预览</a>");
	
	$("#paperlist").hide();
	preview.show();
}
//关闭预览
function removePreview(){
	var preview = $("#prv_mod");	//预览层
	preview.hide();
	$("#paperlist").show();
}

/**删除论文处理**/
function changeState(pid,type){
	var fstate = $("#"+type+pid).attr("value");	
	var tostate="";
	if(fstate == "true")
		tostate = "false";
	else if(fstate == "false")
		tostate = "true";
	else if(fstate == "right")
		tostate = "notright";
	else if(fstate == "notright")
		tostate = "right"; 
	
	
	$.post("changePaperState.php",
		{
			pid:pid,
			state: tostate
		},
		function(state){
			if(state == "ok"){
				if(tostate == "true"){
					$("#ex"+pid).html("已使用").attr("value","true").removeClass("nouse").addClass("use");
					//$("#ex"+pid).attr("value","true");
					//$("#ex"+pid).html("<img src='/img/right.jpg' >");
				}
				else if(tostate == "false"){
					$("#ex"+pid).html("未使用").attr("value","false").removeClass("use").addClass("nouse");
					//$("#ex"+pid).attr("value","false");
					//$("#ex"+pid).html("<img src='/img/wrong.jpg'>");
				}
				else if(tostate == "right"){
					$("#autoconfirm"+pid).html("确认是").attr("value","right").removeClass("notright").addClass("right");
					$("#ex"+pid).html("已使用").attr("value","true").removeClass("nouse").addClass("use");
				}
				else if(tostate == "notright"){
					$("#autoconfirm"+pid).html("确认否").attr("value","notright").removeClass("right").addClass("notright");
					$("#ex"+pid).html("已使用").attr("value","true").removeClass("nouse").addClass("use");
				}
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
		
		<div style="width:1000px">
			<div class="listnav">
				<a href='teacherlist.php?uid=<?PHP echo $uid;?>'>教师列表</a>
				<a href='paperlist.php?uid=<?PHP echo $uid;?>'>论文列表</a>
			</div>
			
			<div id="paperlist" class="result">
				<div class='paperlist'>
					<?PHP
							//获取教师名信息
								$q = "select name,university,ex from teacher where id=$tid";
								$rs = mysql_query($q) or die(mysql_error());
								$r = mysql_fetch_array($rs);
								//print_r($r);
								$tname = $r['name'];
								echo $name;
					
							echo "<table style='width:1000px'><tr><th width=60>序号</th>
								<th>论文题目</th><th>作者信息</th><th width=120>期刊</th>
								<th width=40>使用</th><th width=40>确认</th><th width=40>全对</th><th width=50>部分对</th><th>结果</th></tr>";
					
							$query = "select id,date,title,ex,autoconfirm,name,isright,vipright,cnkiright,exresult from paper where stid=$tid and cn=1 ";
							$result = mysql_query($query) or die(mysql_error());
							
							$comcount = 0;	//含有教师名的论文数
							$j = $start;
							while($row = mysql_fetch_array($result)){
								$pid = $row['id'];
								$j++;
								$ex = $row['ex'];
								$autoconfirm = $row['autoconfirm'];
								$name = $row['name'];
								$exresult = $row['exresult'];
								
								$resstyle = "";
								$rescon = "否";
								if($exresult == 1){
									$resstyle = "background-color:yellow";
									$rescon = "是";
								}
								
								$flag = false;	//标记是否含有教师名
								
								if($autoconfirm == "" || $autoconfirm == null)
									$autoconfirm = "notright";
								$exclass = ($ex=='true'?"use":"nouse");
								$conclass = ($autoconfirm=="right"?"right":"notright");
								
								//作者信息
								$query = "select tname from author where pid=$pid order by rank";
								$re = mysql_query($query);
								$author = array();
								while($r = mysql_fetch_array($re)){
									$author[] = $r['tname'];
									if($r['tname'] == $tname){
										$flag = true;
										$comcount++;
									}
								}
								$authorinfo = join(",",$author);
								
								//单位信息确认
								$allright = "";
								$right = "";
								if($row['isright'] == 5 || $row['vipright'] == 5 || $row['cnkiright'] == 5){
									$right = "部分";
									if($row['isright']==5&&$row['vipright']==5&&$row['cnkiright']==5){
										$allright = "全对";
									}
								}
								
								echo "<tr style='".($flag==false?"background-color:red":"")."' id='".$row['id']."'><td>$j</td><td><a class='prev' title='点击查看详细信息' 
									onclick='getPaperPreview(".$row['id'].")'>".
									$row['title']."</a>"."</td><td>$authorinfo</td><td>".$name."</td><td class=$exclass id='ex$pid' value='$ex' 
									onclick=\"changeState(".$row['id'].",'ex')\">".
									 ($ex=='true'?"已使用":"未使用")."</td><td class=$conclass id='autoconfirm$pid' value='$autoconfirm' 
										onclick=\"changeState(".$row['id'].",'autoconfirm')\">".
									($autoconfirm=='right'?"确认是":"确认否")."</td><td>$allright</td><td>$right</td>
									<td style=$resstyle>$rescon</td></tr>"; 
								/* echo "<tr id='".$row['id']."'><td>$j</td><td><a class='prev' title='点击查看详细信息' 
									onclick='getPaperPreview(".$row['id'].")'>".
									$row['title']."</a>"."</td><td>".$row['date']."</td><td >".
									 "<a id='ex$pid' value='$ex' onclick=\"changeState(".$row['id'].",'ex')\">" .
										"<img src='img/".($ex=='true'?"right.jpg":"wrong.jpg")."'>"
									 ."</a></td><td><img src='img/".($autorconfirm=='right'?"right.jpg":"wrong.jpg")."'  id='autoconfirm$pid' value='$autoconfirm' 
										onclick=\"changeState(".$row['id'].",'autoconfirm')\"></td></tr>";  */
							}
							
							echo "</table>";
							
							echo "正确包含:".$comcount;
						
					?>
				</div>
				
			</div>
			
			<!--预览区-->
			<div id="prv_mod" class="paperpreview">
				<div id="p_title" class="p_title"></div>
				<div id="p_content" class="p_content"></div>
			</div>
			
		</div>
		
	</div>

<!--底部：版权信息-->
<?php include "../include/footer.php"; ?>

</div>
</body>
</html>