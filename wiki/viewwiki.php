<?php
session_start();
include_once("../include/const.inc");
include_once("../include/functions.inc");

if(!isset($_GET['uid']))
	jumpback();
$uid = $_GET['uid'];

//正在登录的用户号
$userid = $_SESSION['uid'];

//得到用户的wikiinfo
$query = "select * from wikiinfo where uid=$uid";
$result = mysql_query($query) or die(mysql_error());
$wikiinfo = "";
$wikiid = -1;
if($row=mysql_fetch_array($result)){
	$wikiinfo = $row['info'];
	$wikiid = $row['id'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="utf-8">
<head>	
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="Description" Content="有关教师个人信息、教师研究信息、教师活动信息等内容，高校教师的更直接、高集成、全方位、多角度的信息展示平台">
<meta name="description" content="university teacher information display">
<meta name="keywords" content="高校教师,研究信息,社会网络,用户编辑">
<meta name="author" content="Wendell">
<link rel="stylesheet" href="css/wiki.css" type="text/css" media="all" />
<link rel="stylesheet" href="../css/hf.css" type="text/css" media="all" />
<title>高校教师人物网——查看wiki</title>

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
<div id="wraper">

<!--包含头部-->
<?php include "../include/header.php";?>

	<!--主体内容-->
	<div id="content">
		<div id="left">
			<?PHP include "../include/leftnav.php";?>
		</div>
		

		<!-- /TinyMCE -->
		<div id="middle">
			<div class="wiki">
				<?PHP
					if($wikiinfo == "")
						echo "还没有网友对该页面进行编辑！<a href='".$BASEURL."/wiki/editwiki.php?uid=$uid'>我来参与</a>";
					else
						echo $wikiinfo;
				?>
			</div>
			<p style="margin-top:10px;font-weight:bold">参与编辑</p>
			<div class="wikieditor">
				<?PHP
					$query = "select id,name,photo from user where id in 
						(select editorid from editwiki where wikiid=$wikiid group by editorid order by edittime desc) limit 6 ";
					$result = mysql_query($query) or die(mysql_error());
					while($row = mysql_fetch_array($result)){
						$editorid = $row['id'];
						$editorname = $row['name'];
						$editorpic = $row['photo'];
						
						echo "<div class='editor'>";
						echo "<div><a target='_blank' href='".$BASEURL.
								"/viewuser/basicinfo.php?uid=$editorid'><img class='editor-pic' src='".$BASEURL."/".$editorpic."'></img></a></div>";
						echo "<div class='editor-name'><a target='_blank' href='".$BASEURL.
								"/viewuser/basicinfo.php?uid=$editorid'>$editorname</a></div>";
						echo "</div>";
					}
				?>
			</div>
		</div>

		<!--right-->
		<div id="right">  
		</div>
		
		
	</div>

<!--底部：版权信息-->
<?php include "../include/footer.php"; ?>
</div>
</body>
</html>

