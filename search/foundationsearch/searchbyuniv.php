<?php
//查询学校基金
include_once("../../include/const.inc");	

function printinfo($info){
	$logger = fopen("log.txt","a");
	if($logger){
		fwrite($logger,$info."\r\n");
	}
	fclose($logger);
}

mysql_select_db($TEACHER_DB,$link) or die(mysql_error());
mysql_query("set names utf8");
	
//学校名
$uname = addslashes($_POST['uname']);
//年份
$year = $_POST['year'];
//分页起始
$start = $_POST['start'];
//页面大小
$pagesize = 40;

$info = array();

//年份限制
$yearcon = "";
if($year != 'all'){
	$yearcon = "and start like \"$year%\" ";
}

$query = "select count(*) as totalnum from foundation where unit=\"$uname\" $yearcon";

//printinfo($query);
$result = mysql_query($query) or die(printinfo(mysql_error()));
if($row=mysql_fetch_array($result)){
	$info[] = $row;
}

//printinfo($uname.$info);
$query = "select * from foundation where unit=\"$uname\" $yearcon limit $start,$pagesize";
$result = mysql_query($query) or die(printinfo(mysql_error()));
while($row=mysql_fetch_array($result)){
	$info[] = $row;
}
//printinfo(json_encode($info));
echo json_encode($info);	
?>