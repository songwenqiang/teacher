<?php
/**
*预览论文内容
*@author wendell
*@date Jane 20th, 2010
**/	

function printinfo($info){
	$logger = fopen("log.txt","a");
	if($logger){
		fwrite($logger,$info."\n");
	}
	fclose($logger);
}

include_once("../include/const.inc");
$tables = array("vipdata","wfdata","cnkidata");

$pid = $_POST["pid"];


mysql_select_db($TEACHER_DB,$link);
mysql_query("set names utf8");

//首先确定选择哪个数据源作为预览
$query = "select vipright,isright,cnkiright from paper where id=".$pid;
//printinfo($query);
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$table = "";

for($i=0;$i<3;$i++){
	//printinfo($row[$i].$i);
	if($row[$i] == 5 || $row[$i] == 6){
		$table = $tables[$i];
		$query = "select * from $table where pid=$pid";
	//	printinfo($row[$i].$i.$query);
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		
		if(strlen(trim($row['cntitle'])) > 6)
			break;
	}
}
//printinfo($row['cntitle']."***".strlen(trim($row['cntitle'])));

if($row['abstract'] == null)
	$row['abstract'] = " ";
if($row['author'] == null)
	$row['author'] = " ";
if($row["authorunit"] == null)
	$row["authorunit"] = " ";
if($row["cnjournal"] == null)
	$row["cnjournal"] = " ";
if($row["enjournal"] == null)
	$row['enjournal'] = " ";
if($row["year"] == null)
	$row["year"] = " ";
if($row["volume"] == null || $row["num"] == "null")
	$row["volume"] = "";
if($row["num"] == null || $row["num"] == "null")
	$row["num"] = "";
if($row["catalognum"] == null)
	$row["catalognum"] = " ";
if($row["foundation"] == null)
	$row["foundation"] = " ";
if($row["keyword"] == null)
	$row["keyword"] = " ";
	
//printinfo($row['num']);
/* $info = array("cntitle"=>trim($row["cntitle"]),"abstract"=>$row["abstract"],"author"=>trim($row["author"]),
	"authorunit"=>trim($row["authorunit"]),"cnjournal"=>trim($row["cnjournal"]),"enjournal"=>trim($row["enjournal"]),
	"year"=>trim($row["year"]),"volume"=>trim($row["volume"]),"num"=>trim($row["num"]),"catalognum"=>trim($row["catalognum"]),
	"foundation"=>trim($row["foundation"]),"keyword"=>trim($row["keyword"])
	);
 */	
$info = array("cntitle"=>$row["cntitle"],"abstract"=>$row["abstract"],"author"=>$row["author"],
	"authorunit"=>$row["authorunit"],"cnjournal"=>$row["cnjournal"],"enjournal"=>$row["enjournal"],
	"year"=>$row["year"],"volume"=>$row["volume"],"num"=>$row["num"],"catalognum"=>$row["catalognum"],
	"foundation"=>$row["foundation"],"keyword"=>$row["keyword"]
	);
	
echo json_encode($info);
?>