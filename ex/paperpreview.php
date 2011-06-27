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
//$tables = array("vipdata","wfdata","cnkidata");

$pid = $_POST["pid"];


//首先确定选择哪个数据源作为预览
/* $query = "select vipright,isright,cnkiright from paper where id=".$pid;
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
} */
//printinfo($row['cntitle']."***".strlen(trim($row['cntitle'])));

/* if($row['abstract'] == null)
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

$info = array("cntitle"=>$row["cntitle"],"abstract"=>$row["abstract"],"author"=>$row["author"],
	"authorunit"=>$row["authorunit"],"cnjournal"=>$row["cnjournal"],"enjournal"=>$row["enjournal"],
	"year"=>$row["year"],"volume"=>$row["volume"],"num"=>$row["num"],"catalognum"=>$row["catalognum"],
	"foundation"=>$row["foundation"],"keyword"=>$row["keyword"]
	); */
$info = array();

$query = "select * from paper where id=$pid";
$result = mysql_query($query);
$row = mysql_fetch_array($result);
$info = $row;

//查询知网信息
if($row['uid'] == -1 ){
	$query = "select abstract from cnkidata where pid=$pid";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	$info['abstract'] = $row['abstract'];
}
//作者信息
$query = "select tname from author where pid=$pid order by rank";
$result = mysql_query($query);
$author = array();
///printinfo($query);
while($row = mysql_fetch_array($result)){
	$author[] = $row['tname'];
}
$info['author'] = join(",",$author);
//关键词信息
$query = "select keyword from keyword where pid=$pid";
$result = mysql_query($query);
$keyword = array();
while($row = mysql_fetch_array($result)){
	$keyword[] = $row['keyword'];
}
$info['keyword'] = join("，",$keyword);

echo json_encode($info);
?>