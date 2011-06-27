<?php
session_start();
include_once("../include/const.inc");
include_once("../include/functions.inc");

//把信息添加到user数据表中
$ename = $_POST['ename'];
$euniv = $_POST['euniv'];
$byear = $_POST['year'];
$bmonth = $_POST['month'];
$bday = $_POST['day'];
$address = $_POST['address'];
$professionalTitle= $_POST['professionalTitle'];
$tutorType = $_POST['tutorType'];
$acad = $_POST['acad'];
$researchTopic = $_POST['researchTopic'];
$researchProject = $_POST['researchProject'];
$archievement = $_POST['archievement'];
$officePhone = $_POST['officePhone'];
$officeAddress = $_POST['officeAddress'];
$record = $_POST['record'];

//是否设置cookie
if(!isset($_SESSION['uid'])){
	jump("register.php");
}
//必填项没有填写，返回上一个页面
if($ename == "" || $euniv == ""){
	echo "<script language='javascript'>";
	echo "alert('请确保必填项(带*号)都填写完整')";
	echo "window.history.back(-1);";
	echo "</script>";
}

$uid = $_SESSION['uid'];
$tid = -1;
if(isset($_SESSION['tid']))
	$tid = $_SESSION['tid'];
	
//更新数据到数据库中
$query = "update user set ename='".dealStr($ename)."' , euniversity='".dealStr($euniv)."' , tid=".$tid;
$query = $query." , birthday='".$byear."-".$bmonth."-".$bday."' , professionalTitle='".$professionalTitle.
	"' , tutorType='".$tutorType."' , academician='".$acad."'";
$query = $query ." , researchTopic='".dealStr($researchTopic)."' , researchProject='".dealStr($researchProject).
	"' , archievement='".dealStr($archievement)."' , officePhone='".$officePhone."' , officeAddress='".
	dealStr($officeAddress)."' , record='".dealStr($record)."' , address='".dealStr($address)."'";
$query = $query . " where id=".$uid;
//echo $query;
mysql_query($query) or die(mysql_error());

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="utf-8">
<head>	
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="Description" Content="有关教师个人信息、教师研究信息、教师活动信息等内容，高校教师的更直接、高集成、全方位、多角度的信息展示平台">
<meta name="description" content="university teacher information display">
<meta name="keywords" content="高校教师,研究信息,社会网络">
<meta name="author" content="Wendell">
<link rel="stylesheet" href="css/register.css" type="text/css" media="all" />
<link rel="stylesheet" href="../css/hf.css" type="text/css" media="all" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script language="javascript" type="text/javascript">
</script>
<title>高校教师人物网——注册页面</title>
</head>

<body>
<div id="wraper">

<!--包含头部-->
<?php include "../include/header.php";?>

<!--主题内容-->
<div id="content">
	<div id="middle">
		<div>注册成功,页面将在3秒内跳转！<br /><span>如果页面没有跳转，请点击
			<a href='http://it.haitianyuan.com/teacher/viewuser/userview.php?uid=<?php echo $uid;?>'这里</div>
		<script language='javascript'>setTimeout("window.location='http://it.haitianyuan.com/teacher/viewuser/userview.php?uid=<?PHP echo $uid;?>'",3000)</script>
	</div>	
</div>

<!--底部：版权信息-->
<?php include "../include/footer.php"; ?>

</div>
</body>
</html>
