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
<title>高校教师人物网——网站收藏夹</title>

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
//删除网站
function delweb(mywebid,fid){
	
	if(!confirm("确定要删除该网址吗"))
		return;
		
	//删除类别
	$.post("delmyweb.php",
	{
		operation:"delete",
		mywebid:mywebid,
		fid:fid
	},
	function(res){
		
		if(res == "notlogin"){
			alert("您还未登录，请登录后执行该操作！");
		}
		else if(res == "failed"){
			alert("添加类别出错，请稍后再试！");
		}
		else if(res == "ok"){
			$("#"+mywebid).remove();
			var num = Number($('#num'+fid).text())-1;
			$("#num"+fid).text(num);
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
					<li id="active"><a href=<?PHP echo "'myweb.php?uid=$uid'";?>>我的收藏</a></li>
					<li><a href=<?PHP echo "'addweb.php?uid=$uid'";?>>添加收藏</a></li>
					<li><a href=<?PHP echo "'myfolder.php?uid=$uid'";?>>类别管理</a></li>
				</ul>
			</div>
			<div class="infobar">
			</div>
			<div>
				<?php
					$query = "select id,name from web_folder where uid=$uid order by click desc";
					$result = mysql_query($query) or die(mysql_error());
				 	while($row = mysql_fetch_array($result)){
						echo "<div class='fblock'>";
						$name = $row['name'];
						$fid = $row['id'];
						
						//得到该文件夹下所有网址
						$q= "select web_myweb.id,web_myweb.title,web_url.url,web_myweb.urlid from web_myweb,web_url where 
								web_myweb.urlid=web_url.id and fid=$fid order by web_myweb.click desc";
						$res = mysql_query($q) or die(mysql_error().$q);
						$rownum = mysql_num_rows($res);
						echo "<div class=\"btitle\"><div class='fname'><span>$name</span></div>
							  <div class='clear'></div>
							  <div class='webnum'>包含<span id='num$fid'>".$rownum."</span>个网站</div></div>";
						echo "<div class='bcon'>";
						while($r=mysql_fetch_array($res)){
							$mywebid = $r['id'];
							$mywebtitle = $r['title'];
							$weburl = $r['url'];
							$urlid = $r['urlid'];
							echo "<div class='web' id='$mywebid'>";
							echo "<div class='title'><a target='_blank' href='countclick.php?url=$weburl&mywebid=$mywebid&fid=$fid&urlid=$urlid&uid=$uid' >$mywebtitle</a></div>";
							//读取标签
						 	echo "<div class='tag'>";
							$q2 = "select tag from web_tag where mywebid=$mywebid";
							$res2 = mysql_query($q2) or die(mysql_error());
							while($r2 = mysql_fetch_array($res2)){
								$tag = $r2['tag'];
								echo "<span>$tag</span>";
							}
							echo "</div>"; 
							
							//功能区
						 	if(isset($_SESSION['uid'])){
								$userid = $_SESSION['uid'];
								if($uid == $userid){	//自己的收藏夹
									echo "<div class='action'><a href='addweb.php?uid=$userid&mywebid=$mywebid&action=edit'>编辑</a><a onclick='delweb($mywebid,$fid)'>删除</a></div>";
									
								}
								else{	//别人的
									echo "<div class='action'><a target='_blank' href='addweb.php?uid=$uid&mywebid=$mywebid&action=collect'>收藏</a></div>";
								}
							} 
							
							echo "</div>";
						}
						echo "</div>";
						echo "</div>";
					} 
					
					//未分类问价夹
					
					$q= "select web_myweb.id,web_myweb.title,web_url.url,web_myweb.urlid from web_myweb,web_url where 
								web_myweb.urlid=web_url.id and fid=-1 and web_myweb.uid=$uid";
					$res = mysql_query($q) or die(mysql_error());
					$num_rows = mysql_num_rows($res);
					if($num_rows > 0){
						echo "<div class='fblock'>";
						echo "<div class=\"btitle\"><div class='fname'><span>未分类</span></div>
								<div class='clear'></div>
								<div class='webnum'>包含<span id='num-1'>$num_rows</span>个网站</div></div>";
						echo "<div class='bcon'>";
					}
					while($r=mysql_fetch_array($res)){
						$mywebid = $r['id'];
						$mywebtitle = $r['title'];
						$weburl = $r['url'];
						$urlid = $r['urlid'];
						echo "<div class='web' id='$mywebid'>";
						echo "<div class='title'><a target='_blank' href='$weburl' >$mywebtitle</a></div>";
						//读取标签
						echo "<div class='tag'>";
						$q2 = "select tag from web_tag where mywebid=$mywebid";
						$res2 = mysql_query($q2) or die(mysql_error());
						while($r2 = mysql_fetch_array($res2)){
							$tag = $r2['tag'];
							echo "<span>$tag</span>";
						}
						echo "</div>";
						//功能区
						if(isset($_SESSION['uid'])){
							$userid = $_SESSION['uid'];
							if($uid == $userid){	//自己的收藏夹
								echo "<div class='action'><a href='addweb.php?uid=$userid&mywebid=$mywebid&action=edit'>编辑</a><a onclick='delweb($mywebid,-1)'>删除</a></div>";
								
							}
							else{	//别人的
								echo "<div class='action'><a target='_blank' href='addweb.php?uid=$uid&mywebid=$mywebid&action=collect'>收藏</a></div>";
							}
						}
						echo "</div>";
						
					}
					echo "</div>";
					echo "</div>"; 
					
				?>
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