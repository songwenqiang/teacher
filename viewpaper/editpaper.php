<?php
session_start();
include_once("../include/const.inc");
include_once("../include/functions.inc");

if(!isset($_GET['pid']))
	exit();
//正在查看的页面的用户ID	
$pid = $_GET['pid'];

$query = "select * from paper where id=$pid";
$result = mysql_query($query) or die(mysql_error());
$uid = -1;
$tid = -1;
if(!$row = mysql_fetch_array($result)){
	exit();
}
$uid = $row['uid'];
$tid = $row['tid'];

//是否登陆
if(!isset($_SESSION['uid']))
	jump("$BASEURL/register/login.php","您还没有登录，请登录后执行该操作！");
//登陆用户ID和查看用户ID是否一致
$userid = $_SESSION['uid'];
if($uid != $userid && $tid != $_SESSION['tid'])
	jump("$BASEURL/viewpaper/addpaper.php?uid=$userid","您无权在别人的页面做此操作，系统已跳回您的页面！");

$ptype = $row['type'];
$title = $row['title'];
$name = $row['name'];
$volume = $row['volume'];
$num = $row['num'];
$page = $row['page'];
$year = $row['date'];
$refurl = $row['refurl'];
$abstract = $row['abstract'];
//获取作者
$query = "select tname from author where pid=$pid";
$result = mysql_query($query);
$authorarr = array();
while($row = mysql_fetch_array($result)){
	$authorarr[] = $row['tname'];
}
$author =  join(",",$authorarr);
//关键词信息
$query = "select keyword from keyword where pid=$pid";
$result = mysql_query($query);
$keywordarr = array();
while($row = mysql_fetch_array($result)){
	$keywordarr[] = $row['keyword'];
}
$keyword = join("，",$keywordarr);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="utf-8">
<head>	
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="Description" Content="有关教师个人信息、教师研究信息、教师活动信息等内容，高校教师的更直接、高集成、全方位、多角度的信息展示平台">
<meta name="description" content="university teacher information display">
<meta name="keywords" content="高校教师,研究信息,论文">
<meta name="author" content="Wendell">
<link rel="stylesheet" href="css/paper.css" type="text/css" media="all" />
<link rel="stylesheet" href="../css/hf.css" type="text/css" media="all" />
<title>高校教师人物网——编辑论文</title>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript">
//提交
function submit(){
	$("#form").submit();
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
				<!--输入方式添加新的论文-->
					<form id="form" class="apply_form" method="post" action="editctrl.php">
						<input type='hidden' name='pid' value="<?PHP echo $pid;?>" />
						<div class="inb">
							<label for="ptype"><em class="em">* </em>类型：</label>
							<select name="ptype">
								<option value="none">请输入</option>
								<option value="conference" <?PHP if($ptype == "Conference Proceedings") echo "selected='selected'";?>
									>会议论文</option>
								<option value="journal" <?PHP if($ptype == "Journal Article") echo "selected='selected'";?>
									>期刊论文</option>
								<option value="thesis" <?PHP if($ptype == "Thesis") echo "selected='selected'";?>>毕业论文</option>
								<option value="book" <?PHP if($ptype == "Book") echo "selected='selected'";?>>书籍</option>
								<option value="other">其他</option>
							</select>
						</div>
						
						<div class="inb">
							<label for="pname"><em class="em">* </em>标题：</label>
							<input type="text" name="pname" value='<?PHP echo $title;?>'/>
						</div>
						<div class="inb">
							<label for="author"><em class="em">* </em>作者：</label>
							<input type="text" name="author" value='<?PHP echo $author;?>'/>
							<span class="tip_txt">
								如有多个作者请以“，”分隔，并按作者顺序输入
							</span>
						</div>
						<div class="inb">
							<label for="name"><em class="em"></em>期刊(会议)名：</label>
							<input type="text" name="name" value='<?PHP echo $name;?>' />
						</div>
						<div class="inb">
							<label for="volume"><em class="em"></em>卷：</label>
							<input type="text" name="volume" value='<?PHP echo $volume;?>' />
						</div>
						<div class="inb">
							<label for="num"><em class="em"></em>期：</label>
							<input type="text" name="num" value='<?PHP echo $num;?>'/>
						</div>
						<div class="inb">
							<label for="page"><em class="em"></em>页数：</label>
							<input type="text" name="page" value='<?PHP echo $page;?>' />
							<span class="tip_txt">
								格式：××-××
							</span>
						</div>
						<div class="inb">
							<label for="year"><em class="em">* </em>年份：</label>
							<input type="text" name="year" value='<?PHP echo $year;?>'>
						</div>
						<div class="inb">
							<label for="refurl"><em class="em"></em>在线参考地址：</label>
							<input type="text" name="refurl" value='<?PHP echo $refurl;?>'>
							<span class="tip_txt">
								网上有关该论文的介绍的URL地址
							</span>
						</div>
						<div class="inb">
							<label for="keyword"><em class="em"></em>论文关键词：</label>
							<input type="text" name="keyword" value='<?PHP echo $keyword;?>' />
							<span class="tip_txt">
								多个关键词请以“，”分隔
							</span>
						</div>
						<div class="inb">
							<label for="abstract"><em class="em"></em>论文摘要：</label>
							<textarea id="abstract" cols="50" rows="5" name="abstract"><?PHP echo $abstract;?></textarea>
						</div>
						<div class="ctrl" id="after_tips">
							<button type="button" onclick="submit()" class="bt">保存信息</button>
						</div>
					</form>
			
		</div>
		
	</div>

<!--底部：版权信息-->
<?php include "../include/footer.php"; ?>

</div>
</body>
</html>