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

//每页显示的论文数目
$pagesize = 30;
$totalnum = getTotalPaperNum($uid,$tid,"notconfirm");
//起始
$start = 0;
if(isset($_GET['start'])){
	if($_GET['start'] >=0 && $_GET['start'] < $totalnum){
		$start = $_GET['start'];
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
<link rel="stylesheet" href="css/paperlist.css" type="text/css" media="all" />
<link rel="stylesheet" href="../css/hf.css" type="text/css" media="all" />
<title>高校教师人物网——论文列表</title>

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
function delPaper(pid){
	if(confirm("确定要删除该篇论文吗？")){
		$.post("changePaperState.php",
			{
				pid:pid,
				state:"delete"
			},
			function(state){
				if(state == "ok"){
					//正确操作后的处理
					$("#confirm"+pid).html("已删除");
					$("#del"+pid).html("已删除");
					$("#edit"+pid).html("已删除");
				}
				else if(state == "notlogin"){
					alert("您还没有登录，请登录后执行该操作");
				}
				else if(state == "noright"){
					alert("对不起，您没有权利对该篇论文执行此操作!");
				}

			}
		);
	}
}
/**确认论文**/
function confirmPaper(pid){
	if(confirm("您确认该篇论文是您的论文，且信息正确！")){
		$.post("changePaperState.php",
			{
				pid:pid,
				state: "right"
			},
			function(state){
				if(state == "ok"){
					//正确操作后的处理
					$("#confirm"+pid).html("已确认");
					$("#del"+pid).html("已确认");
					//$("#edit"+pid).html("已确认");
				}
				else if(state == "notlogin"){
					alert("您还没有登录，请登录后执行该操作");
				}
				else if(state == "noright"){
					alert("对不起，您没有权利对该篇论文执行此操作!");
				}
				
			}
		);
	}
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
			<div class="listnav">
				<a href='truepaperlist.php?uid=<?PHP echo $uid;?>'>确认论文列表</a>
				<a href='ucpaperlist.php?uid=<?PHP echo $uid;?>'>待确认论文列表</a>
			</div>
			
			<div id="paperlist" class="result">
				<div class='paperlist'>
					<?PHP
						if($totalnum == 0){
							echo "<div id='prompt'>当前类别没有论文！</div>";
						}
						else{
							echo "<table><tr><th width=60>序号</th><th>论文题目</th><th width=60>年份</th>
								<th width=40>编辑</th><th width=40>确认</th><th width=40>删除</th></tr>";
					
							$query = "select id,date,title from paper where (uid=$uid or stid=$tid) and 
								(uright='notconfirm' and isright!=5 and vipright!=5 and cnkiright!=5) order by date desc limit $start,$pagesize";
							$result = mysql_query($query) or die(mysql_error());
							
							$j = $start;
							while($row = mysql_fetch_array($result)){
								$pid = $row['id'];
								$j++;
								echo "<tr id='$pid'><td>$j</td><td><a class='prev' title='点击查看详细信息' 
									onclick='getPaperPreview($pid)'>".
									$row['title']."</a>"."</td><td>".$row['date']."</td><td id='edit$pid'><a target='_blank' href='".
									$BASEURL."/viewpaper/editpaper.php?pid=$pid'><img src='img/icon_edit.gif' title='编辑'></a></td>
									<td id='confirm$pid'><div class='icon'  onclick='confirmPaper($pid)'></div></td>
									<td id='del$pid'><img style='cursor:pointer' src='img/icon_del.gif' title='删除'  
									onclick='delPaper($pid)'></td></tr>";
							}
							
							echo "</table>";
						}
					?>
				</div>
				<!--页面导航-->
				<div class="pagenav">
					<div class="number-photo">
						<?php
							$endnum = 0;
							if($start+$pagesize < $totalnum)
								$endnum = $start+$pagesize;
							else
								$endnum = $totalnum;
							echo "第".($start+1)."-".$endnum."篇 / 共".$totalnum."篇";
						?>
					</div>
					<div id="pageTopPanel" class="float-right">
						<ol class="pagerpro">
						<?php
							$url = "$BASEURL/viewpaper/ucpaperlist.php";
							if($totalnum>0){
								//当前页面
								$currpage = $start/$pagesize+1;
								if($start%$pagesize == 0)
									$currpage = $currpage-1;
								
								//打印上一页
								if($start-$pagesize>=0)
									echo "<li><a href='$url?uid=$uid&start=".
										($start-$pagesize)."'>上一页</a></li>";
								
								//打印页面链接
								$pripagenum = 5;	//当前页前面显示5页
								$pagelinknum = 10;	//总共显示11个页面链接
								$startindex = 0;
								$p = 1;				
								if($start > $pripagenum*$pagesize){
									$startindex = $start-$pripagenum*$pagesize;
									$p = $currpage-$pripagenum;
								}
								for($i=$startindex,$j=0;$i<$totalnum && $j<$pagelinknum;$i = $i+$pagesize,$j++){					
									if($i==$start)
										echo "<li class='current'><a href='$url?uid=$uid&start=$start'>$p</a></li>";
									else{
										echo "<li><a href='$url?uid=$uid&start=$i'>$p</a></li>";
									}
									
									$p++;
								}
								//打印下一页链接
								if($start+$pagesize<$totalnum)
									echo "<li><a href='$url?uid=$uid&start=".($start+$pagesize)."'>下一页</a></li>";
							}
						?>
						</ol>
					</div>
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