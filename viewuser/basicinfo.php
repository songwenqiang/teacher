<?php 
session_start();
include_once("../include/const.inc");
include_once("../include/functions.inc");

if(!isset($_GET['uid']))
	Header("Location:$BASEURL/index.php");
//正在查看的页面的用户ID	
$uid = $_GET['uid'];

$query = "select * from user where id=".$uid;
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_array($result);
//print_r($row);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="utf-8">
<head>	
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="Description" Content="有关教师个人信息、教师研究信息、教师活动信息等内容，高校教师的更直接、高集成、全方位、多角度的信息展示平台">
<meta name="description" content="university teacher information display">
<meta name="keywords" content="高校教师,研究信息,社会网络">
<meta name="author" content="Wendell">
<link rel="stylesheet" href="css/content.css" type="text/css" media="all" />
<link rel="stylesheet" href="../css/hf.css" type="text/css" media="all" />
<title>高校教师人物网-基本信息</title>

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
		
		  
		<div id="middle">
		
			<div class="middlebox">
				<div class="title">
					基本信息
				</div>
				<div class="content">
					<div class="">
					<ul>
					<?php 
						echo "<li>姓名：".$row['name']."<span style='margin-left:10px'>".$row['ename']."</span></li>";
						echo "<li>性别：".$row['gender']."</li>";
						echo "<li>学校：".$row['university']."<span style='margin-left:10px'>".$row['euniversity']."</span></li>";
						echo "<li>职称：".$row['professionalTitle']."</li>";
						echo "<li>导师类型：".$row['tutorType']."</li>";
						echo "<li>是否院士：".$row['academician']."</li>";
						echo "<li>个人主页：".$row['personalWebPage']."</li>";
					?>	
					</ul>
					</div>
				</div>	
			</div>

			<div class="middlebox">
				<div class="title">
					研究相关
				</div>
				<div class="content">
					<ul>
					<?php 
						echo "<li>研究领域:".$row['researchTopic']."</li>";
					?>	
					</ul>
				</div>	
			</div>

			<div class="middlebox">
				<div class="title">
					联系方式
				</div>
				<div class="content">
					<ul>
					<?php 
						echo "<li>电话：".$row['officePhone']."</li>";
						echo "<li>邮箱：".$row['email']."</li>";
					?>	
					</ul>
				</div>	
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
  

