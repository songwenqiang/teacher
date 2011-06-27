<?php
//查询某一个教师基金
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
	
//教师名
$tname = addslashes(trim($_POST['tname']));
//学校名
$tuniv = addslashes(trim($_POST['tuniv']));
//分页起始
$start = $_POST['start'];
//页面大小
$pagesize = 40;

if($tname=="")
	exit(0);
if($start=="")
	$start = 0;


$info = array();

$query = "select count(*) as totalnum from foundation where tname=\"$tname\""; 
$ustr = "";
if($tuniv != null || $tuniv != "")
	$ustr = " and unit=\"$tuniv\"";
$query = $query.$ustr;
//printinfo($query);
$result = mysql_query($query) or die(printinfo(mysql_error()));
if($row=mysql_fetch_array($result)){
	$info[] = $row;
}


$query = "select * from foundation where tname=\"$tname\" $ustr limit $start,$pagesize";
//printinfo($query);
$result = mysql_query($query) or die(printinfo(mysql_error()));
while($row=mysql_fetch_array($result)){
	$info[] = $row;
}
//printinfo(json_encode($info));
echo json_encode($info);	
?>