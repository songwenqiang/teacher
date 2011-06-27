<?PHP
/**编辑处理
* Author:Wendell
* DATE：DEC 26th,2010
*/
session_start();
include_once("../include/const.inc");
include_once("../include/functions.inc");

if(!isset($_POST['pid']))
	exit();
//正在查看的页面的用户ID	
$pid = $_POST['pid'];

//登陆用户
if(!isset($_SESSION['uid']))
	jump("$BASEURL/register/login.php","您还没有登录，请登录后执行该操作！");
$uid = $_SESSION['uid'];

$ptype = $_POST['ptype'];
//echo $ptype;
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

$query = "update paper set type=\"$ptype\",title=\"$title\",name=\"$name\",volume=\"$volume\",num=\"$num\",page=\"$page\",
	date=\"$year\",refurl=\"$reful\",abstract=\"$abstract\",uid=\"$uid\",uright='right' where id=$pid";
//echo $query;
$result = mysql_query($query) or die(mysql_error());

//对作者进行处理
//删除原来的信息
$query = "delete from author where pid=$pid";
$result = mysql_query($query) or die(mysql_error());
$author = str_replace("，",",",$author);
$authorarr = explode(",",$author);
//print_r($authorarr);
for($i=0;$i<count($authorarr);$i++){
	if($authorarr[$i] == "")
		continue;
	$puid = -1;
	if($authorarr[$i] == $_SESSION['name'])
		$puid = $uid;
	$query = "insert into author(pid,tid,uid,tname,rank,stid)values($pid,-1,$puid,\"".$authorarr[$i]."\",".($i+1).",-1)";
	//echo $query;
	$result = mysql_query($query) or die(mysql_error());
}

//对关键词进行处理
//删除原有信息
$query = "delete from keyword where pid=$pid";
mysql_query($query) or die(mysql_error());
$keyword = str_replace("，",",",$keyword);
$keywordarr = explode(",",$keyword);
$tid = -1;
if(isset($_SESSION['tid'])){
	$tid = $_SESSION['tid'];
}
for($i=0;$i<count($keywordarr);$i++){
	if($keywordarr[$i] == "")
		continue;
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
						echo "<p>更新成功！<a href='".$BASEURL."/viewpaper/truepaperlist.php?uid=$uid'>继续编辑</a></p>";
					
				?>
			</div>
		</div>
	</div>

<!--底部：版权信息-->
<?php include "../include/footer.php"; ?>

</div>
</body>
</html>