<?PHP
	include_once "../../include/const.inc";
	mysql_select_db($TEACHER_DB,$link) or die(mysql_error());
	mysql_query("set names utf8");

	//
	function getteacherinfo($name){
		$query = "select gender,university from teacher where name='".$name."'";
		$result = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_array($result);
		
		$info=$name;
		if($row){
			$info = $info.",".$row['gender'].",".$row['university'];
		}
		return $info;
	}
	function getteacherid($name){
		$tid = -1;
		$query = "select id from teacher where name='".$name."'";
		$result = mysql_query($query) or die(mysql_error());
		if($row = mysql_fetch_array($result)){
			$tid = $row['id'];
		}
		return $tid;
	}

	$maxsize = 50;	//
	
	$tid = -1;
	if(isset($_POST['tid']) && $_POST['tid']!=null){
		$tid = $_POST['tid'];
	}
	else if(isset($_POST['tname']) && $_POST['tname'] != null){
		$tid = getteacherid($_POST['tname']);
	}
	
	$xmlresult = "<?xml version=\"1.0\" encoding=\"utf-8\"?><graph>";
	if($tid == -1){
		echo $xmlresult."</graph>";
		exit;
	}
	else{	//存在该教师信息
		//获取该教师的信息
		$query = "select name,professionalTitle,tutorType,researchTopic,university from teacher where id=$tid";
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		$tinfo = $row['name'].",".$row['university'];
		if($row['professionalTitle'])
			$tinfo = $tinfo.",".$row['professionalTitle'];
		if($row['tutorType'])
			$tinfo = $tinfo.",".$row['tutortype'];
		if($row['researchTopic'])
			$tinfo = $tinfo."\r\n".$row['researchTopic'];
		$xmlresult = $xmlresult."<Node id=\"$tid\" name=\"".$row['name']."\" desc=\"$tinfo\" nodeColor='0xec870e' nodeSize=\"$maxsize\" teacherid=\"$tid\" />";
	}
	
	
	$query = "select tname,count(*) as tnum from author,paper where author.stid=$tid and author.pid=paper.id and paper.cn=1 group by tname order by tnum desc limit 10";
	$result = mysql_query($query) or die(mysql_eror());
	//echo $query;
	$maxnum = 0;
	
	//过掉当前教师
	$row=mysql_fetch_array($result);
	
	$i = 0;
	$nodesize = 40;
	while($row=mysql_fetch_array($result)){
		$i++;
		$tname = $row['tname'];
		$num = $row['tnum'];
		if($nodesize > 10)
			$nodesize = $nodesize-2;
		
		$tinfo = getteacherinfo($tname);
		$teacherid = getteacherid($tname);
		$xmlresult = $xmlresult."<Node id=\"$i\" name=\"$tname\" desc=\"$tinfo\" nodeColor='0x00AE72' nodeSize=\"$nodesize\" teacherid=\"$teacherid\" />";
		$xmlresult = $xmlresult."<Edge fromID=\"$tid\" toID=\"$i\" edgeLabel=\"$num\" color=\"0x8c63a4\" />";
	}
	$xmlresult = $xmlresult."</graph>";
	echo $xmlresult;

?>