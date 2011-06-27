<?php
session_start();
include_once("../include/const.inc");
include_once("../include/functions.inc");

//教师号
$tid = $_GET['tid'];
$_SESSION['tid'] = $tid;
//用户号
$uid = $_SESSION['uid'];
//在teacher表中绑定用户ID
$query = "update teacher set uid=$uid where id=$tid";
mysql_query($query) or die(mysql_error());

//得到已有信息在页面中展示
$query = "select * from teacher where id=$tid";
$result = mysql_query($query) or die(mysql_error());
$ename = $personalWebPage = $professionalTitle = $tutorType = $researchTopic = $officePhone = $academician = $euniversity = "";
if($row = mysql_fetch_array($result)){
	$ename = $row['ename'];
	$personalWebPage = $row['personalWebPage'];
	$professionalTitle = trim($row['professionalTitle']);
	$tutorType = $row['tutorType'];
	$researchTopic = $row['researchTopic'];
	$officePhone = $row['officePhone'];
	$academician = $row['academician'];
	$euniversity = $row['euniversity'];
}else{
	jump("register2.php","关联账号出现错误，请重试！");
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
<link rel="stylesheet" href="css/register.css" type="text/css" media="all" />
<link rel="stylesheet" href="../css/hf.css" type="text/css" media="all" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script language="javascript" type="text/javascript">
//提交
function brief_submit(){
	$("#info_form3").submit();
}

</script>
<title>高校教师人物网——注册页面</title>
</head>

<body>
<div id="wraper">

<!--包含头部-->
<?php include "../include/header.php";?>

<!--主题内容-->
<div id="content">
	<div id="middle">
		<div class="module">
			<div class="title">编辑信息</div>	
						
			<div class="info">
				<!--用户输入-->
			<form id="info_form3" class="apply_form" method="post" action="register4.php" style="display:<?PHP echo $udisplay;?>">
				<div class="infoblock">
					<div class="btitle">基本信息</div>
					<div class="bcon">
						<p>
							<label for="ename"><em class="em">* </em>英文论文署名：</label>
							<input id="ename" name="ename" type="text" value="<?php echo $ename;?>">
							<div class="tip_txt">
								这里指发表英文论文所用的姓名格式。
							</div>
						</p>
						<p>
							<label for="euniv"><em class="em">* </em>英文学校名称：</label>
							<input id="euniv" name="euniv" type="text" value="<?php echo $euniversity;?>">
							<div class="tip_txt">
								这里指发表英文论文所用的学校英文名。
							</div>
						</p>
						<p>
							<label for="year"><em class="em"></em>生日：</label>
							<select name="year" id="year" class="select" onchange="changeDays('year', 'month', 'day');">
								<option value="0">请选择 </option>
								<?php 
								$dayinfo = getdate();
								$year = $dayinfo["year"];
								for($i=1920;$i<$year;$i++){
									echo "<option value='".$i."'>$i</option>";
								}
								?>
							</select> 年
							<select name="month" id="month" class="select" onchange="changeDays('year', 'month', 'day');">
							<option value="0">请选择 </option>
							<option value="1">1 </option><option value="2">2 </option><option value="3">3 </option><option value="4">4 </option><option value="5">5 </option><option value="6">6 </option><option value="7">7 </option><option value="8">8 </option><option value="9">9 </option><option value="10">10 </option><option value="11">11 </option><option value="12">12 </option>
							</select> 月
							<select name="day" id="day" class="select">
								<option value="0">请选择 </option>
								<option value="1">1 </option><option value="2">2 </option><option value="3">3 </option><option value="4">4 </option><option value="5">5 </option><option value="6">6 </option><option value="7">7 </option><option value="8">8 </option><option value="9">9 </option><option value="10">10 </option><option value="11">11 </option><option value="12">12 </option><option value="13">13 </option><option value="14">14 </option><option value="15">15 </option><option value="16">16 </option><option value="17">17 </option><option value="18">18 </option><option value="19">19 </option><option value="20">20 </option><option value="21">21 </option><option value="22">22 </option><option value="23">23 </option><option value="24">24 </option><option value="25">25 </option><option value="26">26 </option><option value="27">27 </option><option value="28">28 </option><option value="29">29 </option><option value="30">30 </option><option value="31">31 </option>
							</select> 日
						</p>
						<p>
							<label for="address"><em class="em"> </em>地址：</label>
							<input id="adddress" name="address" type="text">
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
							<input id="workUnit" name="workUnit" type="text">
						</p>
						<p>
							<label for="teach"><em class="em"> </em>教授课程：</label>
							<span class="text">
								<textarea onfocus="if(this.value=='请给出所教课程')this.value='';" 
								   class="c_tx2" cols="" rows="" name="teach" id="teach">请给出所教课程</textarea>
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
									if($researchTopic != null && $researchTopic != "")
										echo $researchTopic;
									else
										echo "请给出研究领域";
									?>
								</textarea>
							</span>
						</p>
						<p>
							<label for="researchProject"><em class="em"> </em>研究项目：</label>
							<span class="text">
								<textarea onfocus="if(this.value=='请给出所参加的研究项目')this.value='';" 
								   class="c_tx2" cols="" rows="" name="researchProject" id="researchProject">请给出所参加的研究项目</textarea>
							</span>
						</p>
						<p>
							<label for="archievement"><em class="em"> </em>研究成果：</label>
							<span class="text">
								<textarea onfocus="if(this.value=='请给出研究成果（包括奖项、发明、专利等）')this.value='';" 
								   class="c_tx2" cols="" rows="" name="archievement" id="archievement">请给出研究成果（包括奖项、发明、专利等）</textarea>
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
							<input id="officeAddress" name="officeAddress" type="text">
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
								   class="c_tx2" cols="" rows="" name="record" id="record">请给出补充信息</textarea>
							</span>
						</p>
					</div>
				</div>
				
				<div class="ctrl" id="after_tips">
					<button type="button" onclick="brief_submit()" class="bt">保存并下一步</button>
				</div>
			
			</form>
			</div>
		</div>
		
	</div>	
</div>

<!--底部：版权信息-->
<?php include "../include/footer.php"; ?>

</div>
</body>
</html>
