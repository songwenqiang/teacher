<?php
include_once("../include/const.inc");
include_once("../include/functions.inc");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="utf-8">
<head>	
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="Description" Content="有关教师个人信息、教师研究信息、教师活动信息等内容，高校教师的更直接、高集成、全方位、多角度的信息展示平台">
<meta name="description" content="university teacher information display">
<meta name="keywords" content="高校教师,研究信息,社会网络">
<meta name="author" content="Wendell">
<link rel="stylesheet" href="css/paperlist.css" type="text/css" media="all" />
<link rel="stylesheet" href="../css/hf.css" type="text/css" media="all" />
<title>高校教师人物网——论文列表</title>
<style type="text/css">
.nouse{
cursor:pointer;
	color: black;
	font-weight: bold;
}
.use{
cursor:pointer;
	color: blue;
	font-weight: bold;
}


</style>
<script type="text/javascript" src="../js/jquery.js"></script>
<script language="javascript">

/**处理**/
function changeState(tid){
	var fstate = $("#ex"+tid).attr("value");	
	var tostate="";
	if(fstate == "true")
		tostate = "false";
	else if(fstate == "false")
		tostate = "true";
	
	
	$.post("changeTeacherState.php",
		{
			tid:tid,
			state: tostate
		},
		function(state){
			if(state == "ok"){
				if(tostate == "true"){
					$("#ex"+tid).html("已使用").attr("value","true").removeClass("nouse").addClass("use");
				}
				else if(tostate == "false"){
					$("#ex"+tid).html("未使用").attr("value","false").removeClass("use").addClass("nouse");

				}
			}
		}
	);

}
</script>
</head>

<body>
<div id="wraper">

<!--包含头部-->
<?php include "../include/header.php";?>

	<!--主体内容-->
	<div id="content">
		
		<div style="width:1000px">
			<div class="listnav">
				<a href='teacherlist.php?'>教师列表</a>
			</div>
			
			<div id="paperlist" class="result">
				<div class='paperlist'>
					<?PHP
					
							echo "<table style='width:900px'><tr><th width=60>序号</th>
								<th>教师名</th><th>学校</th><th>论文总数</th><th>确认论文数(or)</th><th>确认论文数(and)</th><th>实验</th><th>人工确认</th></tr>";
					
							$query = "select stid,count(*) as pnum from paper where cn=1 group by stid order by pnum desc limit 200";
							$result = mysql_query($query) or die(mysql_error());
							
							$j = 0;
							while($row = mysql_fetch_array($result)){
								$j++;
								
								$stid = $row['stid'];
								$pnum = $row['pnum'];
								
								//获取教师信息
								$q = "select name,university,ex from teacher where id=$stid";
								//echo $q;
								$rs = mysql_query($q) or die(mysql_error());
								$r = mysql_fetch_array($rs);
								//print_r($r);
								$name = $r['name'];
								$university = $r['university'];
								$ex = $r['ex'];
								$exclass="nouse";
								if($ex == "true")
									$exclass="use";
								
								//获取确认论文数
								$q = "select count(*) as n from paper where (isright=5 or cnkiright=5 or vipright=5) and stid=$stid";
								$rs = mysql_query($q);
								$r = mysql_fetch_array($rs);
								$ypnum = $r['n'];
								
								//获取全部确认论文数
								$q = "select count(*) as n from paper where (isright=5 and cnkiright=5 and vipright=5) and stid=$stid";
								$rs = mysql_query($q);
								$r = mysql_fetch_array($rs);
								$andnum = $r['n'];
								
							
								echo "<tr tid='".$row['id']."'><td>$j</td><td><a target='_blank' href='../viewteacher/teacherview.php?tid=$stid'> $name</a></td>
								      <td>$university</td><td>$pnum</td>
								     <td>$ypnum</td><td>$andnum</td><td class=$exclass id='ex$stid' value='$ex' onclick=\"changeState($stid)\">".
									 ($ex=='true'?"已使用":"未使用")."</td><td><a target='_blank' href='paperlist.php?tid=$stid'>开始</a></td></tr>"; 
							}
							
							echo "</table>";
						
					?>
				</div>
				
			</div>
			
			
		</div>
		
	</div>

<!--底部：版权信息-->
<?php include "../include/footer.php"; ?>

</div>
</body>
</html>