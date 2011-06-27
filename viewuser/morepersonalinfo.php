<?php
session_start();
include_once("../include/const.inc");
include_once("../include/functions.inc");

//正在查看页面的ID
if(!isset($_GET['uid'])){
	jump("../index.php","请选择要查看的用户");
}
$uid = $_GET['uid'];

//当前登录用户ID
if(!isset($_SESSION['uid']))
	jump("basicinfo.php?uid=$uid","只有登录用户才能查看更多信息！^-_-^");

$query = "select * from user where id=$uid";
$result = mysql_query($query) or die(mysql_error());
$ename = $personalWebPage = $professionalTitle = $tutorType = $researchTopic = $officePhone = $academician = $euniversity = "";
$address = $researchProject = $position = $teach = $student = $workunit = $record = "";
if($row = mysql_fetch_array($result)){
	$name = $row['name'];
	$university = $row['university'];
	$ename = $row['ename'];
	$personalWebPage = $row['personalWebPage'];
	$professionalTitle = trim($row['professionalTitle']);
	$tutorType = $row['tutorType'];
	$researchTopic = beforeDis($row['researchTopic']);
	$officePhone = $row['officePhone'];
	$academician = $row['academician'];
	$euniversity = $row['euniversity'];
	$birthday = $row['birthday'];
	$address = $row['address'];
	$researchProject = beforeDis($row['researchProject']);
	$position = beforeDis($row['position']);
	$teach = beforeDis($row['teach']);
	$student = beforeDis($row['student']);
	$workUnit = beforeDis($row['workUnit']);
	$record = $row['record'];
	$photo = $row['photo'];
}else{
	jump("../index.php");
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
<link rel="stylesheet" href="css/content.css" type="text/css" media="all" />
<link rel="stylesheet" href="../css/hf.css" type="text/css" media="all" />
<title>高校教师人物网——详细信息</title>

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
				<div class="infoblock">
					<div class="btitle">基本信息</div>
					<div class="bcon">
						<div class="lb">
							<ul>
							<?PHP
								echo "<li><div class='attr'>姓名：</div>$name <span>$ename</span></li>";
								echo "<li><div class='attr'>学校：</div>$university<span>$euniversity</span></li>";
								echo "<li><div class='attr'>生日：</div>$birthday</li>";
								echo "<li><div class='attr'>地址：</div>$address </li>";
								echo "<li><div class='attr'>个人主页地址：</div>$personalWebPage </li>";
							?>
							</ul>
						</div>
						<div class="rb">
							<div class="img">
								<img src="<?php echo "../".$photo; ?>" />
							</div>
						</div>
						
					</div>
				</div>
			
				<div class="infoblock">
					<div class="btitle">工作信息</div>
					<div class="bcon">
						<ul>
							<?PHP
								echo "<li><div class='attr'>职称：</div>$professionalTitle</li>";
								echo "<li><div class='attr'>导师类型：</div>$tutorType</li>";
								echo "<li><div class='attr'>院士：</div>$academician</li>";
								echo "<li><div class='attr'>工作单位：</div>$workUnit </li>";
								echo "<li><div class='attr'>教授课程：</div>$teach </li>";
							?>
						</ul>
						
					</div>
				</div>
				
				<div class="infoblock">
					<div class="btitle">研究信息</div>
					<div class="bcon">
						<ul>
							<?PHP
								echo "<li><div class='attr'>研究领域：</div><div class='val'>$researchTopic</div></li>";
								echo "<li><div class='attr'>研究项目：</div><div class='val'>$researchProject</div></li>";
								echo "<li><div class='attr'>研究成果：</div><div class='val'>$archievement </div></li>";
							?>
						</ul>
					</div>
				</div>
				
				<div class="infoblock">
					<div class="btitle">联系信息</div>
					<div class="bcon">
						<ul>
							<?PHP
								echo "<li><div class='attr'>办公电话：</div>$officePhone</li>";
								echo "<li><div class='attr'>办公地址：</div>$officeAddress </li>";
							?>
						</ul>
					</div>
				</div>
				
				<div class="infoblock">
					<div class="btitle">补充信息</div>
					<div class="bcon">
						<ul>
							<?PHP
								echo "<li><div class='attr'>补充信息：</div><div class='val'>$record</div></li>";
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



