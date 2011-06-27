<?PHP
include_once("../include/const.inc");

//记录访问者信息
function logger(){
	
	$info = date("Y-m-d H:i:s")."\t".$_SERVER['REMOTE_ADDR']."\t".$_SERVER['HTTP_USER_AGENT']."\t".$_SERVER["HTTP_REFERER"]."\n";
	
	$filename="spiderlog.txt";
	if($_SERVER['HTTP_REFERER']){
		$filename="userlog.txt";
	}
	
	$fp = fopen($filename,"a");
	fwrite($fp,$info);
	fclose($fp);
	
	//fwrite($fp,date("Y-m-d H:i:s"));
	
	//fwrite($fp,"\t");
	//fwrite($fp,$_SERVER['REMOTE_ADDR']);
	//fwrite($fp,"\t");
	//fwrite($fp,$_SERVER['HTTP_X_REWRITE_URL']);
	//fwrite($fp,"\t");
	//fwrite($fp,$_SERVER['HTTP_USER_AGENT']);
	//fwrite($fp,"\t");
	//fwrite($fp,$_SERVER["HTTP_REFERER"]);
	//fwrite($fp,"\n");
}

//记录访问信息
logger();

 if($_GET['name'] != null && $_GET['university'] != null){	//分别给出
		//echo "2";
		$tname = $_GET['name'];
		$university = $_GET['university'];
		$query = "select * from teacher where name='".$tname."' and university='".$university."'";	
}

		
	mysql_select_db($TEACHER_DB,$link) or die(mysql_error());
	mysql_query("set names utf8");
	$result = mysql_query($query) or die(mysql_error());
	
	if($row=mysql_fetch_array($result)){
		$tid = $row['id'];
		echo $tid;
		Header("Location:../viewteacher/teacherview.php?tid=$tid");
	}
	else{
		
	}
	
?>