<?php
/*ҳ����ת����
*$url--Ҫ��ת����ҳ���ַ $info��תʱ��ʾ����Ϣ
*/
function jump($url,$info=""){
	echo "<script language=\"javascript\" type=\"text/javascript\">";
	if($info != "")
		echo "alert('".$info."');";
	echo "location='".$url."';";
	echo "</script>";
}

/**ҳ����ת��������ת����һ��ҳ��
*$info ��תʱ�Ƿ���ʾ��Ϣ
*/
function jumpback($info=""){
	echo "<script language='javascript'>";
	if($info != "")
		echo "alert('".$info."')";
	echo "window.history.back(-1);";
	echo "</script>";
}

/*�������ݿ�ǰ�ַ�������
*
*/
function dealStr($str){
	return addslashes(trim($str));
}
/**���ݿ��ı���Ϣ��ʾǰ�Ĵ���
*
*/
function beforeDis($str){
	return nl2br(trim($str));
}
/**����tid,�õ�uid
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
/**����uid���õ�tid
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

/**�õ�ĳһ�û�����ʦ�����ĵ�����
*uidΪ�û��ţ�tidΪ��ʦ�ţ�typeΪ��Ҫ��ѯ������
*uid��tidͬʱ������Ϊ���߲�������һ�£��Զ�������TID�����û��������uid
*�ú�����paperlist���õ�
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