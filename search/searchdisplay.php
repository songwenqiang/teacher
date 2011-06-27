<?php
	session_start();
	include ("../include/const.inc");
	
	//以空格分隔的 姓名+学校 方式
	if($_GET['keyword'] != null){
		//echo "1";
		$keyword = $_GET['keyword'];
		$arr = explode(" ",$keyword);
		if(count($arr) > 2){
			echo "<script language=javascript>window.location.href='search.php'</script>";
		}
		$query = "select * from teacher where name='".$arr[0]."' ";
		if(count(arr) == 2){
			$query = $query . " and university='".$arr[1]."'";
		}
	}
	else if($_GET['name'] != null && $_GET['university'] != null){	//分别给出
		//echo "2";
		$tname = $_GET['name'];
		$university = $_GET['university'];
		$query = "select * from teacher where name='".$tname."' and university='".$university."'";	
	}
	else if(isset($_GET['university']) && $_GET['university'] != null){
		//echo "3";
		$query = "select * from teacher where university='".$_GET['university']."'";
	}
	else if(isset($_GET['name']) && $_GET['name'] != null){
		//echo "4";
		$query = "select * from teacher where name='".$_GET['name']."'";	
	}
	else{	//出错
		echo "<script language=javascript>window.location.href='search.php'</script>";
		return;
	}

	include_once("../include/const.inc");	
	mysql_select_db($TEACHER_DB,$link) or die(mysql_error());
	mysql_query("set names utf8");
	
//	echo "here".$tname.$university;
//	echo $query;
	$result = mysql_query($query) or die(mysql_error());
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="utf-8">
<head>	
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="Description" Content="有关教师个人信息、教师研究信息、教师活动信息等内容，高校教师的更直接、高集成、全方位、多角度的信息展示平台">
<meta name="description" content="university teacher information display">
<meta name="keywords" content="高校教师,搜索">
<meta name="author" content="Wendell">
<link rel="stylesheet" href="css/searchdisplay.css" type="text/css" media="all" />
<link rel="stylesheet" href="../css/hf.css" type="text/css" media="all" />
<title>高校教师人物网</title>
</head>

<body>
<div id="wraper">

<!--包含头部-->
<?php include "../include/header.php";?>

<!--主题内容-->
<div id="content">
<div id="middle">
	<div class="search">		
			<div class="searchcontent">
				<form method="get" action="searchdisplay.php">
				<table>
					<tr><td style="padding-right:20px">姓名</td><td><input class="s_input" type="text" name="name"></td><td rowspan=2 style="padding-left:20px;">
						<input type="submit" value="搜索" style="text-align:center;height:30px;width: 50px"></td></tr>
					<tr><td style="padding-right:20px">学校</td><td><input class="s_input" type="text" name="university"></td></tr>
				</table>
				</form>
			</div>
	</div>
	
	<div id="result">
		<ul>
		<?php
			while($row=mysql_fetch_array($result)){
				$uid = $row['uid'];
				$tid = $row['id'];
				$tname = $row['name'];
				$researchTopic = $row['researchTopic'];
				$pPage = $row['personalWebPage'];
				$university= $row['university'];
				$gender = $row['gender'];
				$professionalTitle = $row['professionalTitle'];
				
				$url = "../viewteacher/teacherview.php?tid=$tid";
				if($uid != -1){
					$url = "$BASEURL/viewuser/basicinfo.php?uid=$uid";
				}
				
				echo "<li><div class='listitem'>";
				echo "<div class='listitem_title'><a target='_blank' href='$url'>".
					$tname."</a><span>$gender</span><span>$professionalTitle</span><span>".$university."</span></div>";
				if($researchTopic != null)
					echo "<div class='listitem_content'>研究领域：".$researchTopic."</div>";
				echo "<div class='listitem_site'>".$pPage."</div>";
				echo "</div></li>";
			}
		?>
		</ul>
	</div>
	
</div>	
</div>

<!--底部：版权信息-->
<?php include "../include/footer.php"; ?>

</div>
</body>
</html>
