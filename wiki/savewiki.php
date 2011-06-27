<?PHP
session_start();
include_once("../include/const.inc");
include_once("../include/functions.inc");

//正在登录的用户号
$userid = $_SESSION['uid'];

//正在编辑的页面所属用户ID
if(!isset($_POST['uid']))
	jump($BASEURL."/index.php");
$uid = $_POST['uid'];

if(isset($_POST['wikiinfo']) && $_POST['wikiinfo'] != ""){
	$wikiinfo = dealStr($_POST['wikiinfo']);
	$query = "select * from wikiinfo where uid=$uid";
	$result = mysql_query($query) or die(mysql_error());
	
	//已有，更新
	if($row=mysql_fetch_array($result)){
		$wikiid = $row['id'];
		$query = "update wikiinfo set info=\"$wikiinfo\" where uid=$uid";
		mysql_query($query) or die(mysql_error());
		$query = "insert into editwiki(wikiid,editorid,edittime) values($wikiid,$userid,now())";
		mysql_query($query) or die(mysql_error());
	}
	else{
		$query = "insert into wikiinfo(uid,info)values($uid,\"$wikiinfo\")";
		mysql_query($query) or die(mysql_error());
		$query = "select last_insert_id() as id from wikiinfo";
		$result = mysql_query($query) or die(mysql_error());
		if($row=mysql_fetch_array($result)){
			$wikiid = $row['id'];
			$query = "insert into editwiki(wikiid,editorid,edittime) values($wikiid,$userid,now())";
			mysql_query($query) or die(mysql_error());
		}
	}
}	

jump($BASEURL."/wiki/viewwiki.php?uid=$uid");
?>