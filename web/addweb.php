<?php
session_start();
include_once("../include/const.inc");
include_once("../include/functions.inc");

//是否登陆
if(!isset($_SESSION['uid']))
	jump("$BASEURL/register/login.php","您还没有登录，请登录后执行该操作！");
//登陆用户ID和查看用户ID是否一致
$userid = $_SESSION['uid'];

$uid = -1;
if(isset($_GET['uid'])){
	//正在查看的页面的用户ID	
	$uid = $_GET['uid'];
}

//正在进行的操作  收藏 ，保存 还是 修改
$action = "save";
if(isset($_GET['action'])){
	$action = $_GET['action'];
}

$mywebid = -1;
if(isset($_GET['mywebid']))
	$mywebid = $_GET['mywebid'];
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
<title>高校教师人物网——添加网址</title>

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
			<div class="tabnav">
				<ul>
					<li><a href=<?PHP echo "'myweb.php?uid=$userid'";?>>我的收藏</a></li>
					<li id="active"><a href=<?PHP echo "'addweb.php?uid=$userid'";?>>添加收藏</a></li>
					<li><a href=<?PHP echo "'myfolder.php?uid=$userid'";?>>类别管理</a></li>
				</ul>
			</div>
			
			<div class="infobar">
			<?PHP 
				//插入处理
				if(isset($_GET['url'])){
					//echo "here";
					$url = $_GET['url'];
					$title = $_GET['title'];
					$des = $_GET['des'];
					$tag = $_GET['tag'];
					$fid = $_GET['folder'];
					//echo $url.$title.$des.$tag.$fid;
					if($url=="" || $title=="" || $tag==""){
						echo "<div class='err'>";
						echo "<h4>错误</h4>";
						echo "<ul>";
						if(!ereg("(((f|ht){1}tp://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)",$url)){
							echo "<li>该URL链接无效</li>";
						}
						if($title == "" || strlen($title) < 2){
							echo "<li>标题太短，至少2个字符</li>";
						}
						if($tag == ""){
							echo "<li>至少输入一个标签</li>";
						}
						echo "</ul>";
						echo "</div>";
						
					}
					else{
						//echo "here";
						$url = dealStr($url);
						$title = dealStr($title);
						$des = dealStr($des);
						
						//echo $url.$title.$des;
						$urlid = -1;
						$unum = 0;
						//查找该网址是否已经存在
						$query = "select id,unum from web_url where url='$url'";
						$result = mysql_query($query) or die(mysql_error());
						if($row = mysql_fetch_array($result)){
							$urlid = $row['id'];
							$unum = $row['unum'];
							
						}
						else{	//该网址还没有添加
							$query = "insert into web_url(url,title,uid,unum,time)values('$url','$title',$userid,0,now())";
							$result = mysql_query($query) or die(mysql_error().$query);
							$query = "select last_insert_id() as id from web_url";
							$result = mysql_query($query) or die(mysql_error());
							$row = mysql_fetch_array($result);
							$urlid = $row['id'];
						}
						//更新用户收藏夹
						//编辑直接删除原来的数据
						if($action == "edit"){
							$query = "delete from web_tag where mywebid=$mywebid";
							mysql_query($query) or die(mysql_error());
							$query = "delete from web_myweb where id=$mywebid";
							mysql_query($query) or die(mysql_error());
						}
						$query = "insert into web_myweb(urlid,uid,fid,title,des,time)values($urlid,
							$userid,$fid,'".$title."','".$des."',now())";
						$result = mysql_query($query) or die(mysql_error());
						$query = "select last_insert_id() as id from web_myweb";
						$result = mysql_query($query) or die(mysql_error());
						if($row = mysql_fetch_array($result)){
							$mywebid = $row['id'];
							//插入标签
							$tag = str_replace("，",",",$tag);	//替换中文，
							$tagarr = explode(",",$tag);
							for($i=0;$i<count($tagarr);$i++){
								$query = "insert into web_tag(mywebid,tag) values($mywebid,'".$tagarr[$i]."')";
								$result = mysql_query($query);
								
							}
						}
						
						
						//收藏和保存的时候更改数量
						if($action == "save" || $action == "collect"){
							//更新该URL的收藏用户数
							$query = "update web_url set unum=".($unum+1)." where id=$urlid";
							$result = mysql_query($query) or die(mysql_error());
							//更新用户该类别的URL数
							$query = "select num from web_folder where id=$fid";
							$result = mysql_query($query) or die(mysql_error());
							if($row=mysql_fetch_array($result)){
								$funum = $row['num']+1;
								$query = "update web_folder set num=$funum where id=$fid";
								mysql_query($query) or die(mysql_error());
							}
						}
						$action = "save";
						//显示正确处理信息
						echo "<div class='right'>已插入该网站信息到数据库！</div>";
					}
				} 
			?>
			</div>
			<?PHP
				$url = "http://";
				$title = "";
				$des = "";
				$tag = "";
				$fid = -1;
				//echo "action=$action&getaction=".$_GET['action'];
				//收藏 和 编辑的时候 读取数据
				if(isset($_GET['action']) && ($action=='edit' || $action=='collect')){
					$mywebid = $_GET['mywebid'];
					$query = "select web_url.url,web_myweb.title,web_myweb.des,web_myweb.fid from 
							web_myweb,web_url where web_myweb.id=$mywebid and urlid=web_url.id";
					$result = mysql_query($query) or die(mysql_error());
					if($row=mysql_fetch_array($result)){
						$url = $row['url'];
						$title = $row['title'];
						$des = $row['des'];
						$fid = $row['fid'];
					}
					//获取标签
					$query = "select tag from web_tag where id=$mywebid";
					$result = mysql_query($query) or die(mysql_error());
					if($row=mysql_fetch_array($result)){
						$tag = $row['tag'];
					}
					while($row=mysql_fetch_array($result)){
						$tag = $tag.",".$row['tag'];
					}
				}
			?>
			<div>
				<form id="form" class="apply_form" method="get" action="addweb.php">
					<div class='inb'>
						<label for="url">网站地址:</label>
						<input id="url" type="text" name="url" value="<?PHP echo $url;?>">
					</div>
					<div class='inb'>
						<label for="title">网站标题:</label>
						<input id="title" type="text" name="title" value="<?PHP echo $title;?>">
					</div>
					<div class="inb">
						<label for="des">功能说明:</label>
						<textarea id="des" rows='6' name="des"><?PHP echo $des;?></textarea>
					</div>
					<div class="inb">
						<label for="tag">分类标签：</label>
						<input id="tags" type="text" name="tag" value="<?PHP echo $tag;?>">
						<span class="tip_txt">
								多个标签请以“，”分隔
						</span>
					</div>
					<div class="inb">
						<label for="tag">保存到文件夹：</label>
						<select name="folder">
							<option selected="" value="-1">未分类文件夹</option>
							<?php
								$query = "select id,name from web_folder where uid=$userid";
								$result = mysql_query($query);
								while($row = mysql_fetch_array($result)){
									
									$folderid = $row['id'];
									$name = $row['name'];
									if($action=="edit" && $folderid==$fid)
										echo "<option value='$folderid' selected='selected'>$name</option>";
									else
										echo "<option value='$folderid'>$name</option>";
								}
							?>
						</select>
					</div>
					
					<input type='hidden' name='action' value='<?PHP echo $action;?>' />
					<input type='hidden' name='mywebid' value='<?PHP echo $_GET['mywebid'];?>' />
					<div class="ctrl" id="after_tips">
						<button type="button" onclick="submit()" class="bt">保存信息</button>
					</div>
				</form>
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