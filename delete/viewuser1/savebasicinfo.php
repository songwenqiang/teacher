<?PHP
session_start();
include_once("../include/const.inc");
include_once("../include/functions.inc");

if(!isset($_SESSION['uid']))
	jump("../index.php","对不起，你没有权限编辑，请先登录");
 //正在登录的用户号
$uid = $_SESSION['uid'];

//把信息添加到user数据表中
$ename = $_POST['ename'];
$euniv = $_POST['euniv'];
$byear = $_POST['year'];
$bmonth = $_POST['month'];
$bday = $_POST['day'];
$address = $_POST['address'];
$professionalTitle= $_POST['professionalTitle'];
$tutorType = $_POST['tutorType'];
$acad = $_POST['acad'];
$researchTopic = $_POST['researchTopic'];
$researchProject = $_POST['researchProject'];
$archievement = $_POST['archievement'];
$officePhone = $_POST['officePhone'];
$officeAddress = $_POST['officeAddress'];
$record = $_POST['record'];


//头像信息
$orifilename = $_FILES["imgfile"]["name"];
$tmpname = $_FILES["imgfile"]["tmp_name"];
$filetype = strtolower(substr($orifilename,strrpos($orifilename,".")));
$imgfile = "file/headimg/$uid".$filetype;
$r = move_uploaded_file($tmpname,$BASEDIR."/".$imgfile);
if($_FILES["imgfile"]["error"] > 0){
	if(!$r)
		$imgfile = "file/headimg/default.jpg";
}

//必填项没有填写，返回上一个页面
if($ename == "" || $euniv == ""){
	jumpback('请确保必填项(带*号)都填写完整');
}

$uid = $_SESSION['uid'];
	
//更新数据到数据库中
$query = "update user set ename='".dealStr($ename)."' , euniversity='".dealStr($euniv)."', photo='".$imgfile."'";
$query = $query." , birthday='".$byear."-".$bmonth."-".$bday."' , professionalTitle='".$professionalTitle.
	"' , tutorType='".$tutorType."' , academician='".$acad."'";
$query = $query ." , researchTopic='".dealStr($researchTopic)."' , researchProject='".dealStr($researchProject).
	"' , archievement='".dealStr($archievement)."' , officePhone='".$officePhone."' , officeAddress='".
	dealStr($officeAddress)."' , record='".dealStr($record)."' , address='".dealStr($address)."'";
$query = $query . " where id=".$uid;
//echo $query;
mysql_query($query) or die(mysql_error());

jump("userview.php?uid=$uid&type=41");
?>