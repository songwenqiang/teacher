<?PHP
/**以第一种方式（输入信息）添加论文
* Author:Wendell
* DATE：DEC 24th,2010
*/
session_start();
include_once("../include/const.inc");
include_once("../include/functions.inc");
//登陆用户
if(!isset($_SESSION['uid']))
	jump("$BASEURL/register/login.php","您还没有登录，请登录后执行该操作！");
$uid = $_SESSION['uid'];

$ptype = $_POST['ptype'];
if($ptype == "conference")
	$ptype = "Conference Proceedings";
else if($ptype == "journal")
	$ptype = "Journal Article";
else if($ptype == "book")
	$ptype = "Book";
else if($ptype == "thesis")
	$ptype = "Thesis";
else
	$ptype = "Other"; 

$title = dealStr($_POST['pname']);
$author = dealStr($_POST['author']);
$name = dealStr($_POST['name']);
$volume = dealStr($_POST['volume']);
$num = dealStr($_POST['num']);
$page = dealStr($_POST['page']);
$year = dealStr($_POST['year']);
$refurl = dealStr($_POST['refurl']);
$abstract = dealStr($_POST['abstract']);
$keyword = dealStr($_POST['keyword']);

$query = "insert into paper(type,title,name,volume,num,page,date,refurl,abstract,uid,uright) values(
	\"$ptype\",\"$title\",\"$name\",\"$volume\",\"$num\",\"$page\",\"$year\",\"$reful\",
	\"$abstract\",\"$uid\",'right')";
$result = mysql_query($query) or die(mysql_error());
$query = "select last_insert_id() as id from paper";
$result = mysql_query($query) or die(mysql_error());
$pid = -1;
if($row=mysql_fetch_array($result)){
	$pid = $row['id'];
}else{
	exit();//添加出错
}

//对作者进行处理
$authorarr = preg_split("/[,，；;]/",$author,-1,PREG_SPLIT_NO_EMPTY);
for($i=0;$i<count($authorarr);$i++){
	$puid = -1;
	if($authorarr[$i] == $_SESSION['name'])
		$puid = $uid;
	$query = "insert into author(pid,tid,uid,tname,rank,stid)values($pid,-1,$puid,\"".$authorarr[$i]."\",".($i+1).",-1)";
	$result = mysql_query($query) or die(mysql_error());
}

//对关键词进行处理
$keywordarr = preg_split("/[,，；;]/",$keyword,-1,PREG_SPLIT_NO_EMPTY);
$tid = -1;
if(isset($_SESSION['tid'])){
	$tid = $_SESSION['tid'];
}
for($i=0;$i<count($keywordarr);$i++){
	$query = "insert into keyword(pid,tid,keyword)values($pid,$tid,'".$keywordarr[$i]."')";
	$result = mysql_query($query) or die(mysql_error());
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="utf-8">
<head>	
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="Description" Content="有关教师个人信息、教师研究信息、教师活动信息等内容，高校教师的更直接、高集成、全方位、多角度的信息展示平台">
<meta name="description" content="university teacher information display">
<meta name="keywords" content="高校教师,添加论文">
<meta name="author" content="Wendell">
<link rel="stylesheet" href="../css/hf.css" type="text/css" media="all" />
<title>高校教师人物网——添加论文</title>

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
<script type="text/css">
.info{
	line-height: 150%;
	margin: 20px 20px;
	padding:20px;
}
.info p{
	
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
			<div class='info'>
				<?PHP
					if($result)
						echo "<p>添加成功！<a href='".$BASEURL."/viewpaper/addpaper.php?uid=$uid'>继续添加</a></p>";
					else
						echo "<p>添加失败！请重试</p>";
				?>
			</div>
		</div>
	</div>

<!--底部：版权信息-->
<?php include "../include/footer.php"; ?>

</div>
</body>
</html>