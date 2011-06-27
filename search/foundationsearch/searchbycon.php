<?php
//查询内容基金
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
	
//关键词
$keyword = addslashes($_POST['keyword']);
//年份
$year = $_POST['year'];
//分页起始
$start = $_POST['start'];
//页面大小
$pagesize = 40;

//年份限制
$yearcon = "";
if($year != 'all'){
	$yearcon = "and start like \"$year%\" ";
}

$info = array();

//内容关键词
if($keyword == null || $keyword == "")
	exit(0);
$karr = preg_split("/[ | ]/s",$keyword);
printinfo($keyword);
$sk = "(pname like \"%".$karr[0]."%\"";
for($i=1;$i<count($karr);$i++){
	$sk = $sk . " or pname like \"%".$karr[$i]."%\"";
}
$sk = $sk.")";

$query = "select count(*) as totalnum from foundation where $sk $yearcon ";
//printinfo($query);
$result = mysql_query($query) or die(printinfo(mysql_error()));
if($row=mysql_fetch_array($result)){
	$info[] = $row;
}


$query = "select * from foundation where $sk $yearcon limit $start,$pagesize";
//printinfo($query);
$result = mysql_query($query) or die(printinfo($query."\r\n".mysql_error()));
while($row=mysql_fetch_array($result)){
	$info[] = $row;
}
//printinfo(json_encode($info));
echo json_encode($info);	

?>