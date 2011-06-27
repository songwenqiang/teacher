<?PHP
/**用户更改论文状态的处理
* Author:Wendell
* DATE：DEC 26th,2010
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

if(!isset($_POST['pid'])){
	echo "nopid";
	exit();
}
//正在查看的页面的用户ID	
$pid = $_POST['pid'];
//要改变到的状态
$state = $_POST['state'];

//printinfo($pid);

//登陆用户
if(!isset($_SESSION['uid'])){
	echo "notlogin";
	exit();
}
$userid = $_SESSION['uid'];
$tid = -1;
if(isset($_SESSION['tid']))
	$tid = $_SESSION['tid'];

//判断该论文是否属于当前用户
$query = "select * from paper where id=$pid";
$result = mysql_query($query);
if($row = mysql_fetch_array($result)){
	if($userid == $row['uid'] || $tid == $row['stid']){
		$query = "";
		if($state == "delete"){
			//***********并不真正删除，而是更改状态
			$query = "update paper set uright='delete' where id=$pid";
		}
		else if($state == "right"){
			//确认是
			$query = "update paper set uright='right' where id=$pid";
		}
		else if($state == "notright"){
			//确定不是
			$query = "update paper set uright='notright' where id=$pid";
		}
		else if($state == "notconfirm"){
			//等待确认
			$query = "update paper set uright='notconfirm' where id=$pid";
		}
		$result = mysql_query($query);
		if($result){
			echo "ok";
		}
	}
	else{
		echo "noright";
	}
}
else{
	echo "nopaper";
}
?>