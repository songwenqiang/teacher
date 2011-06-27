<?PHP
/**用户导航类别管理
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

if($operation == "add"){
	$name = dealStr($_POST['name']);
	if($name == null || $name == ""){
		echo "failed";
		exit();
	}
	$query = "insert into web_folder(uid,name,time,num)values($userid,'$name',now(),0)";
	$result = mysql_query($query);
	if($result){
		$query = "select * from web_folder where uid=$userid order by time desc limit 1";
		//printinfo($query);
		$result = mysql_query($query);
		if($row = mysql_fetch_array($result)){
			$info = array();
			$info['id'] = $row['id'];
			$info['name'] = $row['name'];
			$info['time'] = $row['time'];
			$info['num'] = $row['num'];
			echo json_encode($info);
			//printinfo(json_encode($row));
		}
	}else{
		echo "failed";
	}
}
else if($operation == "edit"){
	$cid = $_POST['cid'];
	$name = dealStr($_POST['name']);
	if($name == null || $name == ""){
		echo "failed";
		exit();
	}
	$query = "update web_folder set name=$name where id=$cid";
	$result = mysql_query($query);
	if($result){
		echo "ok";
	}
}
else if($operation == "delete"){
	$cid = $_POST['cid'];
	$query = "delete from web_myweb where fid=$cid";
	$result = mysql_query($query);
	$query = "delete from web_folder where id=$cid";
	$result = mysql_query($query);
	echo "ok";
}

?>