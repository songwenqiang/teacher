<?php 
   $lifetime = 60;
   session_set_cookie_params($lifetime);
   session_start();
   include_once("../include/const.inc");
   include_once("../include/functions.inc");
/****************************************/   
	if(isset($_GET['type']))
		$type = $_GET['type'];
	else
		$type = "10";
   
  if(isset($_GET['tid']))
  	$tid = $_GET['tid'];
  else
		jump("../index.php");

/***导航信息***/
$nav_page = array(
			array("basicinfo.php"),
			array("basicpaperinfo.php","detailpaperinfo.php"),
			array("coauthorRE.php","departRE.php")
		);

$nav_info = array(
			array("概况介绍"),
			array("论文概况","论文详细"),
			array("合作论文","单位关系")
			);
			
$r = floor($type/10);	//行信息
$c = $type%10;				//列信息
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="utf-8">
<head>	
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/content.css" type="text/css" media="all" />
<link rel="stylesheet" href="../css/hf.css" type="text/css" media="all" />
<title>高校教师人物网</title>

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

<!--主题内容-->
<div id="content">
   <div id="left">
   		<div class="navbox">
   			<div class='title'>个人信息</div>
   				<ul>
   					<?php 
   						if($r == 1 && $c == 0)
   							echo "<li>".$nav_info[0][0]."</li>";
   						else 
   							echo "<li><a href='teacherview.php?tid=".$tid."&type=10'>".$nav_info[0][0].">></a></li>";	
   					?>
   				</ul>
   		</div>
   		
   		<div class="navbox">
   			<div class="title">研究相关</div>
   			<ul>
   				<?php 
   						 
   						for($i=0;$i<count($nav_info[1]);$i++){
   							if($r==2 && $c == $i)
   								echo "<li>".$nav_info[1][$i]."</li>";
   							else
   								echo "<li><a href='teacherview.php?tid=".$tid."&type=2".$i."'>".$nav_info[1][$i].">></a></li>";	   						
   						}
   					?>
   			</ul>
   		</div>
   		
   		<div class="navbox">
   			<div class="title">关系展示</div>
   			<ul>
   				<?php 
						for($i=0;$i<count($nav_info[2]);$i++){
   							if($r==3 && $c == $i)
   								echo "<li>".$nav_info[2][$i]."</li>";
   							else
   								echo "<li><a href='teacherview.php?tid=".$tid."&type=3".$i."'>".$nav_info[2][$i].">></a></li>";	   						
   						}
						
   						/* if($r == 3 && $c == $i)
   							echo "<li>".$nav_info[2][0]."</li>";
   						else 
   							echo "<li><a href='teacherview.php?tid=".$tid."&type=30'>".$nav_info[2][0].">></a></li>";	 */
   					?>
   			</ul>
   		</div>
		
		<!--搜索框-->
		<div class="searchbox">
			<div class="title">搜索</div>
			<form action="../search/searchdisplay.php" method="get">
					<input id="search" size="17" name="keyword" type="text">
			</form>
		</div>

   </div>
   
   <!--middle and right -->
  
      <?php 
		include ($nav_page[$r-1][$c]);	
      ?> 
   
</div>

<?php
	mysql_close($link) or die(mysql_error()); 
?>
<div id="flashContent"> </div> 

<!--底部：版权信息-->
<?php include "../include/footer.php"; ?>

</div>
</body>
</html>
