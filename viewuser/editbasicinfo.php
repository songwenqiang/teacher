 <?php
session_start();
include_once("../include/const.inc");
include_once("../include/functions.inc");

if(!isset($_SESSION['uid']))
	jumpback();
 //正在登录的用户号
$uid = $_SESSION['uid'];


//得到已有信息在页面中展示
$query = "select * from user where id=$uid";
$result = mysql_query($query) or die(mysql_error());
$ename = $personalWebPage = $professionalTitle = $tutorType = $researchTopic = $officePhone = $academician = $euniversity = "";
$address = $researchProject = $position = $teach = $student = $workunit = $record = "";
$photo = "";
if($row = mysql_fetch_array($result)){
	$ename = $row['ename'];
	$personalWebPage = $row['personalWebPage'];
	$professionalTitle = trim($row['professionalTitle']);
	$tutorType = $row['tutorType'];
	$researchTopic = beforeDis($row['researchTopic']);
	$officePhone = $row['officePhone'];
	$academician = $row['academician'];
	$euniversity = $row['euniversity'];
	$birthday = $row['birthday'];
	$address = $row['address'];
	$researchProject = beforeDis($row['researchProject']);
	$position = beforeDis($row['position']);
	$teach = beforeDis($row['teach']);
	$student = beforeDis($row['student']);
	$workUnit = beforeDis($row['workUnit']);
	$record = $row['record'];
	$photo = $row['photo'];
	//echo strlen($record);
}else{
	jumpback();
}

$year = $day = $month = "";
if($birthday != ""){
	$barr = explode("-",$birthday);
	$year = $barr[0];
	$month = $barr[1];
	$day = $barr[2];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="utf-8">
<head>	
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="Description" Content="有关教师个人信息、教师研究信息、教师活动信息等内容，高校教师的更直接、高集成、全方位、多角度的信息展示平台">
<meta name="description" content="university teacher information display">
<meta name="keywords" content="高校教师,研究信息,社会网络">
<meta name="author" content="Wendell">
<link rel="stylesheet" href="css/content.css" type="text/css" media="all" />
<link rel="stylesheet" href="../css/hf.css" type="text/css" media="all" />
<title>高校教师人物网——编辑信息</title>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript"> 
try {
var pageTracker = _gat._getTracker("UA-6403547-1");
pageTracker._trackPageview();
} catch(err) {}</script>
<script type="text/javascript" src="../js/jquery.js"></script>
<script language="javascript">
	//提交
function brief_submit(){
	$("#basicinfo").submit();
}
 </script>
</head>

<body>
<div id="wraper">

<!--包含头部-->
<?php include "../include/header.php";?>

	<!--主体内容-->
	<div id="content">
		<div id="left">
			<?PHP include "../include/leftnav.php";?>
		</div>
		
		<div id="middle">
			<form id="basicinfo" class="apply_form" method="post" enctype="multipart/form-data" action="savebasicinfo.php">
						<div class="infoblock">
							<div class="btitle">基本信息</div>
							<div class="bcon">
								
								<p>
									<label for="ename"><em class="em">* </em>英文论文署名：</label>
									<input id="ename" name="ename" type="text" value="<?php echo $ename;?>">
									<span class="tip_txt">
										这里指发表英文论文所用的姓名格式。
									</span>
								</p>
								<p>
									<label for="euniv"><em class="em">* </em>英文学校名称：</label>
									<input id="euniv" name="euniv" type="text" value="<?php echo $euniversity;?>">
									<span class="tip_txt">
										这里指发表英文论文所用的学校英文名。
									</span>
								</p>
								<p>
									<label for="img"><em class="em"> </em>更换头像：</label>
									<input id="imgfile" name="imgfile" type="file" />
								</p>
								<p>
									<label for="year"><em class="em"></em>生日：</label>
									<select name="year" id="year" class="select" onchange="changeDays('year', 'month', 'day');">
										<?php
										if($year == "" || $year == "0"){
											echo "<option value=\"0\">请选择 </option>";
										}
								
												
										$dayinfo = getdate();
										$year = $dayinfo["year"];
										for($i=1920;$i<$year;$i++){
											if($year == $i){
												echo "<option value='".$i."' selected='selected'>$i</option>";
											}
											else{
												echo "<option value='".$i."'>$i</option>";
											}
										}
										?>
									</select> 年
									<select name="month" id="month" class="select" onchange="changeDays('year', 'month', 'day');">
										<?php
										if($month == "" || $month == "0"){
											echo "<option value=\"0\">请选择 </option>";
										}	
												
										for($i=1;$i<=12;$i++){
											if($month == $i){
												echo "<option value='".$i."' selected='selected'>$i</option>";
											}
											else{
												echo "<option value='".$i."'>$i</option>";
											}
										}
										?>
									</select> 月
									<select name="day" id="day" class="select">
										<?php
										if($day == "" || $day == "0"){
											echo "<option value=\"0\">请选择 </option>";
										}	
												
										for($i=1;$i<=31;$i++){
											if($day == $i){
												echo "<option value='".$i."' selected='selected'>$i</option>";
											}
											else{
												echo "<option value='".$i."'>$i</option>";
											}
										}
										?>
									</select> 日
								</p>
								<p>
									<label for="address"><em class="em"> </em>地址：</label>
									<input id="adddress" name="address" type="text" value="<?PHP echo $address;?>">
								</p>
								<p>
									<label for="pwb"><em class="em"> </em>个人主页地址：</label>
									<input id="pwp" name="personWebPage" type="text" value="<?php echo $personalWebPage;?>">
								</p>

							</div>
						</div>
					
						<div class="infoblock">
							<div class="btitle">工作信息</div>
							<div class="bcon">
								<p>
									<label for="professionalTitle"><em class="em"> </em>职称：</label>
									<select name="professionalTitle" id="professionalTitle" class="selected" >
										<option value="未知">请输入</option>
										<?php 
											for($i=0;$i<count($professionalTitleArr);$i++){
												$pt = $professionalTitleArr[$i];
												if($pt == $professionalTitle)
													echo "<option value=\"$pt\" selected='selected'>$pt</option>";
												else
													echo "<option value=\"$pt\">$pt</option>";
											}
										?>
									</select>
								</p>
								<p>
									<label for="tutorType"><em class="em"> </em>导师类型：</label>
									<select name="tutorType" id="tutorType" class="select">
										<option value="未知">未知 </option>
										<?php 
											echo $tutorType;
											for($i=0;$i<count($tutorTypeArr);$i++){
												$tt = $tutorTypeArr[$i];
												if($tt == $tutorType)
													echo "<option value=\"$tt\" selected='selected'>$tt</option>";
												else
													echo "<option value=\"$tt\">$tt</option>";
											}
										?>
									</select>
								</p>
								<p>
									<span class="f_label"><em class="em"> </em>是否院士：</span>
									<input id="acad_n" class="radio" type="radio" value="非院士" name="acad" 
										<?PHP if($academician != "院士") echo "checked='checked'";?>>
										非院士
									<input id="acad_y" class="radio" type="radio" value="院士" name="acad"
										<?PHP if($academician == "院士") echo "checked='checked'";?>>
										院士
								</p>
								<p>
									<label for="workUnit"><em class="em"> </em>工作单位：</label>
									<input id="workUnit" name="workUnit" type="text" value="<?PHP echo $workUnit;?>">
								</p>
								<p>
									<label for="teach"><em class="em"> </em>教授课程：</label>
									<span class="text">
										<textarea onfocus="if(this.value=='请给出所教课程')this.value='';" 
										   class="c_tx2" cols="" rows="" name="teach" id="teach" ><?PHP echo $teach; ?></textarea>
									</span>
								</p>
							</div>
						</div>
						
						<div class="infoblock">
							<div class="btitle">研究信息</div>
							<div class="bcon">
								<p>
									<label for="researchTopic"><em class="em"> </em>研究领域：</label>
									<span class="text">
										<textarea onfocus="if(this.value=='请给出研究领域')this.value='';" 
										   class="c_tx2" cols="" rows="" name="researchTopic" id="researchTopic">
										   <?PHP 
												echo $researchTopic;
											?>
										</textarea>
									</span>
								</p>
								<p>
									<label for="researchProject"><em class="em"> </em>研究项目：</label>
									<span class="text">
										<textarea onfocus="if(this.value=='请给出所参加的研究项目')this.value='';" 
										   class="c_tx2" cols="" rows="" name="researchProject" id="researchProject">
										   <?PHP 
												echo $researchProject;
											?>
										</textarea>
									</span>
								</p>
								<p>
									<label for="archievement"><em class="em"> </em>研究成果：</label>
									<span class="text">
										<textarea onfocus="if(this.value=='请给出研究成果（包括奖项、发明、专利等）')this.value='';" 
										   class="c_tx2" cols="" rows="" name="archievement" id="archievement">
											<?PHP 
												echo $archievement;
											?>
										</textarea>
									</span>
								</p>
							</div>
						</div>
						
						<div class="infoblock">
							<div class="btitle">联系信息</div>
							<div class="bcon">
								<p>
									<label for="officePhone"><em class="em"> </em>办公电话：</label>
									<input id="officePhone" name="officePhone" type="text" value="<?PHP echo $officePhone;?>">
								</p>
								
								<p>
									<label for="officeAddress"><em class="em"> </em>办公地址：</label>
									<input id="officeAddress" name="officeAddress" type="text" value="<?PHP echo $address;?>">
								</p>
							</div>
						</div>
						
						<div class="infoblock">
							<div class="btitle">补充信息</div>
							<div class="bcon">
								<p>
									<label for="record"><em class="em"> </em>履历等信息：</label>
									<span class="text">
										<textarea onfocus="if(this.value=='请给出补充信息')this.value='';" 
										   class="c_tx2" cols="" rows="" name="record" id="record"><?PHP echo $record;?>
										</textarea>
									</span>
								</p>
							</div>
						</div>
						
						<div class="ctrl" id="after_tips">
							<button type="button" onclick="brief_submit()" class="bt">保存信息</button>
						</div>
					
					</form>

		</div>

		  <!--right-->
		<div id="right">  
		</div>
		
	</div>

<!--底部：版权信息-->
<?php include "../include/footer.php"; ?>

</div>
</body>
</html>