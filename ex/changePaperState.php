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


//正在查看的页面的用户ID	
$pid = $_POST['pid'];
//要改变到的状态
$state = $_POST['state'];

//printinfo($pid);

$query = "";
if($state == "true"){
	//***********在实验室中使用
	$query = "update paper set ex='true' where id=$pid";
}
else if($state == "false"){
	//在实验中不使用
	$query = "update paper set ex='false' where id=$pid";
}
else if($state == "right"){
	//该论文确定是
	$query = "update paper set autoconfirm='right' , ex='true' where id=$pid";
}
else if($state == "notright"){
	//论文确定不是
	$query = "update paper set autoconfirm='notright',ex='true' where id=$pid";
}
$result = mysql_query($query);
if($result){
	echo "ok";
}
	
?>