<?php
/*页面跳转函数
*$url--要跳转到的页面地址 $info跳转时显示的信息
*/
function jump($url,$info=""){
	echo "<script language=\"javascript\" type=\"text/javascript\">";
	if($info != "")
		echo "alert('".$info."');";
	echo "location='".$url."';";
	echo "</script>";
}

/**页面跳转函数，跳转到上一个页面
*$info 跳转时是否提示信息
*/
function jumpback($info=""){
	echo "<script language='javascript'>";
	if($info != "")
		echo "alert('".$info."')";
	echo "window.history.back(-1);";
	echo "</script>";
}

/*插入数据库前字符串处理
*
*/
function dealStr($str){
	return addslashes(trim($str));
}
/**数据库文本信息显示前的处理
*
*/
function beforeDis($str){
	return nl2br(trim($str));
}
/**给定tid,得到uid
*
*/
function getUIDbyTID($tid){
	if($tid == -1)
		return -1;
	$uid = -1;
	
	$query = "select uid from teacher where id=$tid";
	$result = mysql_query($query) or die(mysql_error());
	if($row = mysql_fetch_array($result)){
		$uid = $row['uid'];
	}
	return $uid;
}
/**给定uid，得到tid
*/
function getTIDbyUID($uid){
	if($uid == -1)
		return -1;
	$tid = -1;
	
	$query = "select tid from user where id=$uid";
	$result = mysql_query($query) or die(mysql_error());
	if($row = mysql_fetch_array($result)){
		$tid = $row['tid'];
	}
	return $tid;
}

/**得到某一用户或老师的论文的总数
*uid为用户号，tid为教师号，type为所要查询的类型
*uid和tid同时用是因为二者并不总是一致，自动爬的有TID，而用户输入的是uid
*该函数在paperlist里用到
*/
function getTotalPaperNum($uid,$tid,$type){
	$query = "";
	if($type == "right"){
		$query = "select count(*) as num from paper where (uid=$uid or stid=$tid) and (uright='right' or 
				(uright='notconfirm' and(isright=5 or vipright=5 or cnkiright=5)))";
	}
	else if($type == "notconfirm"){
		$query = "select count(*) as num from paper where (uid=$uid or stid=$tid) and (uright='notconfirm' and isright!=5
				and vipright!=5 and cnkiright!=5)";
	}
	else if($type == "notright"){
		
	}
	//echo $query;
	$totalnum = 0;
	$result = mysql_query($query) or die(mysql_error().$query);
	if($row = mysql_fetch_array($result)){
		$totalnum = $row['num'];
	}
	return $totalnum;
}
?>