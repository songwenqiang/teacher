<?PHP
/**删除用户文件夹下的某个网址
* Author:Wendell
* DATE：Jan 11th,2011
*/
function printinfo($info){
	$logger = fopen("log.txt","a");
	if($logger){
		fwrite($logger,$info."\r\n");
	}
	fclose($logger);
}
session_start();
include_once("../include/const.inc");
include_once("../include/functions.inc");

//要改变到的状态
$operation = $_POST['operation'];
//printinfo($pid);

//登陆用户
if(!isset($_SESSION['uid'])){
	echo "notlogin";
	exit();
}
$userid = $_SESSION['uid'];

//删除某一文件夹下的
if($operation == "delete"){
	$mywebid = $_POST['mywebid'];
	$fid = $_POST['fid'];
	//更新总的网址数
	//TODO
	//更新类别下的网址数
	$query = "select num from web_folder where id=$fid";
	$result = mysql_query($query);
	if($row = mysql_fetch_array($result)){
		$num = $row['num']-1;
		$query = "update web_folder set num=$num where id=$fid";
		mysql_query($query);
	}
	//删除该网址
	$query = "delete from web_myweb where id=$mywebid";
	$result = mysql_query($query);
	echo "ok";
}

?>