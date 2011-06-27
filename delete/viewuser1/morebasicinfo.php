 <?php
//正在查看页面的ID
if(!isset($_GET['uid'])){
	jump("../index.php","请选择要查看的用户");
}

//当前登录用户ID
if(!isset($_SESSION['uid']))
	jump("userview.php","只有登录用户才能查看更多信息！^-_-^");

$query = "select * from user where id=$uid";
$result = mysql_query($query) or die(mysql_error());
$ename = $personalWebPage = $professionalTitle = $tutorType = $researchTopic = $officePhone = $academician = $euniversity = "";
$address = $researchProject = $position = $teach = $student = $workunit = $record = "";
if($row = mysql_fetch_array($result)){
	$name = $row['name'];
	$university = $row['university'];
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
}else{
	jump("userview.php");
}

?>
 <div id="middle">
				<div class="infoblock">
					<div class="btitle">基本信息</div>
					<div class="bcon">
						<div class="lb">
							<ul>
							<?PHP
								echo "<li><div class='attr'>姓名：</div>$name <span>$ename</span></li>";
								echo "<li><div class='attr'>学校：</div>$university<span>$euniversity</span></li>";
								echo "<li><div class='attr'>生日：</div>$birthday</li>";
								echo "<li><div class='attr'>地址：</div>$address </li>";
								echo "<li><div class='attr'>个人主页地址：</div>$personalWebPage </li>";
							?>
							</ul>
						</div>
						<div class="rb">
							<div class="img">
								<img src="<?php echo "../".$photo; ?>" />
							</div>
						</div>
						
					</div>
				</div>
			
				<div class="infoblock">
					<div class="btitle">工作信息</div>
					<div class="bcon">
						<ul>
							<?PHP
								echo "<li><div class='attr'>职称：</div>$professionalTitle</li>";
								echo "<li><div class='attr'>导师类型：</div>$tutorType</li>";
								echo "<li><div class='attr'>院士：</div>$academician</li>";
								echo "<li><div class='attr'>工作单位：</div>$workUnit </li>";
								echo "<li><div class='attr'>教授课程：</div>$teach </li>";
							?>
						</ul>
						
					</div>
				</div>
				
				<div class="infoblock">
					<div class="btitle">研究信息</div>
					<div class="bcon">
						<ul>
							<?PHP
								echo "<li><div class='attr'>研究领域：</div><div class='val'>$researchTopic</div></li>";
								echo "<li><div class='attr'>研究项目：</div><div class='val'>$researchProject</div></li>";
								echo "<li><div class='attr'>研究成果：</div><div class='val'>$archievement </div></li>";
							?>
						</ul>
					</div>
				</div>
				
				<div class="infoblock">
					<div class="btitle">联系信息</div>
					<div class="bcon">
						<ul>
							<?PHP
								echo "<li><div class='attr'>办公电话：</div>$officePhone</li>";
								echo "<li><div class='attr'>办公地址：</div>$officeAddress </li>";
							?>
						</ul>
					</div>
				</div>
				
				<div class="infoblock">
					<div class="btitle">补充信息</div>
					<div class="bcon">
						<ul>
							<?PHP
								echo "<li><div class='attr'>补充信息：</div><div class='val'>$record</div></li>";
							?>
						</ul>
					</div>
				</div>
</div>

  <!--right-->
<div id="right">  
</div>
