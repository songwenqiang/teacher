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
include_once("../include/const.inc");


$tid = $_POST['tid'];
//要改变到的状态
$state = $_POST['state'];

//printinfo($pid);

$query = "";
if($state == "true"){
	//***********在实验室中使用
	$query = "update teacher set ex='true' where id=$tid";
}
else if($state == "false"){
	//在实验中不使用
	$query = "update teacher set ex='false' where id=$tid";
}
$result = mysql_query($query);
if($result){
	echo "ok";
}
	
?>