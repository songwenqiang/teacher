 <div id="middle">
<?php 
			$query = "select * from user where id=".$uid;
			$result = mysql_query($query) or die(mysql_error());
			$row = mysql_fetch_array($result);
			//print_r($row);
?>
<div class="middlebox">
	<div class="title">
		基本信息
	</div>
	<div class="content">
		<div class="">
		<ul>
		<?php 
			echo "<li>姓名：".$row['name']."<span style='margin-left:10px'>".$row['ename']."</span></li>";
			echo "<li>性别：".$row['gender']."</li>";
			echo "<li>学校：".$row['university']."<span style='margin-left:10px'>".$row['euniversity']."</span></li>";
			echo "<li>职称：".$row['professionalTitle']."</li>";
			echo "<li>导师类型：".$row['tutorType']."</li>";
			echo "<li>是否院士：".$row['academician']."</li>";
			echo "<li>个人主页：".$row['personalWebPage']."</li>";
		?>	
		</ul>
		</div>
	</div>	
</div>

<div class="middlebox">
	<div class="title">
		研究相关
	</div>
	<div class="content">
		<ul>
		<?php 
			echo "<li>研究领域:".$row['researchTopic']."</li>";
		?>	
		</ul>
	</div>	
</div>

<div class="middlebox">
	<div class="title">
		联系方式
	</div>
	<div class="content">
		<ul>
		<?php 
			echo "<li>电话：".$row['officePhone']."</li>";
			echo "<li>邮箱：".$row['email']."</li>";
		?>	
		</ul>
	</div>	
</div>


</div>

  <!--right-->
<div id="right">  
</div>
