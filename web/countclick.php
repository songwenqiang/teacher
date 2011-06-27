<?PHP
/**记录网站链接点击次数
* Author:Wendell
* DATE：Jan 16th,2011
*/
/*改变表中字段的数目
*增加step或者减少step
*$OP- plus  minus
*/
function changeNum($table,$field,$con,$op="plus",$step=1){
	$query = "select $field from $table where $con";
	$result = mysql_query($query) or die($query.mysql_error());
	$num = 0;
	if($row = mysql_fetch_array($result)){
		$num = $row["$field"];
	}
	//增加数
	if($op == "plus"){
		$num = $num + $step;
	}
	else{
		$num = $num - $step;
	}
	$query = "update $table set $field=$num where $con";
	mysql_query($query) or die($query.mysql_error());
}

session_start();
include_once("../include/const.inc");
include_once("../include/functions.inc");
//登录用户
if(isset($_SESSION['uid']) && isset($_GET['uid'])){
	if($_SESSION['uid'] != $_GET['uid'])
		break;
	//更新该URL的点击数
	if(isset($_GET['mywebid'])){
		$mywebid = $_GET['mywebid'];
		changeNum("web_myweb","click","id=$mywebid");
	}
	//更新该文件夹下的URL点击次数
	if(isset($_GET['fid'])){
		$fid = $_GET['fid'];
		changeNum("web_folder","click","id=$fid");
	}
}
 
//更新该URL的点击次数
if(isset($_GET['urlid'])){
	$urlid = $_GET['urlid'];
	changeNum("web_url","click","id=$urlid");
}
if(isset($_GET['url'])){
	$url = $_GET['url'];
	jump($url);
} 
?>