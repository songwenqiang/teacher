<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="utf-8">
<head>	
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="Description" Content="有关教师个人信息、教师研究信息、教师活动信息等内容，高校教师的更直接、高集成、全方位、多角度的信息展示平台">
<meta name="description" content="university teacher information display">
<meta name="keywords" content="高校教师,研究信息,论文">
<meta name="author" content="Wendell">
</head>

<body>
<?php
session_start();
include_once("../include/const.inc");
include_once("../include/functions.inc");

//正在查看页面的ID
if(!isset($_GET['uid'])){
	jump("../index.php","请选择要查看的用户");
}
$uid = $_GET['uid'];
//利用UID得到TID
$tid = getTIDbyUID($uid);


$query = "select id,date,title,name,volume,num,page from paper where (uid=$uid or stid=$tid) and (uright='right' or 
	(uright='notconfirm' and(isright=5 or vipright=5 or cnkiright=5))) 
	order by date desc ";
$result = mysql_query($query) or die(mysql_error().$query);

$j=0;
while($row = mysql_fetch_array($result)){
	$j++;
	//得到论文作者
	$sql = "select tname from author where pid=".$row['id']." order by rank ";
	$rs = mysql_query($sql) or die(mysql_error($sql));
	if($r=mysql_fetch_array($rs))
		echo str_replace(","," ",$r['tname']);
	while($r=mysql_fetch_array($rs)){
		echo ",".str_replace(","," ",$r['tname']);
	}
	
	echo ".".$row['title'];	//论文标题
	if($row['name'])	//期刊名
		echo ".".$row['name'];
	if($row['date'])
		echo ",".$row['date'];//日期
	if($row['volume'])
		echo ",".$row['volume'];
	if($row['num'])
		echo "(".$row['num'].")";
	if($row['page'])
		echo ":".$row['page'];
			
	mysql_free_result($rs);	
	
	echo "<br />";
}
mysql_free_result($result);
			
?>
</body>
</html>