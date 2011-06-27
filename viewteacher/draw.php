<?php
/******************/
require_once ("../include/const.inc");	
require_once ('../jpgraph/jpgraph.php');
require_once ('../jpgraph/jpgraph_line.php');
/******************/


$tid = $_GET['tid'];
mysql_select_db($TEACHER_DB,$link) or die(mysql_error());

$query = "select date,count(*) as num from paper where (isright=1 or vipright=1 or
          cnkiright=1) and cn=1 and paper.stid=$tid group by date";

$result = mysql_query($query) or die(mysql_error());
$i=0;
$maxnum = 5;
while($row=mysql_fetch_array($result)){
	if(!$row['date'])	//日期为空
		continue;
	//$years[] = substr($row['date'],2);
	$years[] = $row['date'];
	$pnum[] = $row['num'];
	$i++;
	
	if($row['num'] > $maxnum)
		$maxnum = $row['num'];
}
 
// Create the graph and set a scale.
// These two calls are always required
$graph = new Graph(400,200,"auto");
$graph->img->SetMargin(15,10,10,10);
$graph->img->SetAntiAliasing();
$graph->SetScale('textlin',0,$maxnum);
$graph->yscale->ticks->Set($maxnum,1);	//y轴坐标设置
$graph->yaxis->HideTicks(true,false);
$graph->xaxis->SetTextTickInterval(4,0);	//x轴坐标间距
//$graph->yaxis->scale->ticks->Set(10);
$graph->SetFrame(false);
//$graph->SetShadow();

$graph->SetMarginColor("white");
$graph->xaxis->SetPos("min");
$graph->yaxis->HideZeroLabel();

$graph->xaxis->SetTickLabels($years);
$graph->xaxis->SetLabelAngle(0);
$graph->xaxis->SetFont(FF_SIMSUN,FS_BOLD);


// Create the linear plot
$lineplot=new LinePlot($pnum);
$lineplot->mark->SetType(MARK_FILLEDCIRCLE);
$lineplot->mark->SetFillColor("#DF0029");
$lineplot->mark->SetWidth(3);
$lineplot->SetColor("#205aa7");
$lineplot->SetWeight(2);
$lineplot->SetCenter();

// Add the plot to the graph
$graph->Add($lineplot);

//$graph->title->Set("趋势图");
//$graph->xaxis->title->Set("year");
//$graph->yaxis->title->Set("paper num");
$graph->xaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
$graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
$graph->title->SetFont(FF_SIMSUN,FS_BOLD);

 
// Display the graph
$graph->Stroke();
?>