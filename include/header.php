<div id="header">
  <div id="h_content">
	<div id="h_left"><a href=""><img src="http://it.haitianyuan.com/teacher/image/logo.png" alt="tnet" style="width:180px;height:72px"></img></a></div>
	<div id="h_right">
		<h1 style="padding:20px 20px 10px 30px;float:left;font-size:30px">高校教师人物网</h1>
		<!--<div style="position:relative"><img src="../image/pnet.png" style="width:300px;height:72px"></img></div>-->
	</div>
  </div>
</div>

<!--navigation-->
<div id="nav">
   <ul>
	  <li><a  href="http://it.haitianyuan.com/teacher/index.php"><span>首页</span></a></li>
	  <?PHP
		if(isset($_SESSION['uid'])){
			echo "<li><a  href=\"http://it.haitianyuan.com/teacher/viewuser/basicinfo.php?uid=".$_SESSION['uid'].
			"\"><span>个人主页</span></a></li>";
		}
	  ?>
    <!--  <li><a target="_blank" href=""><span>统计</span></a></li> 
      <li><a target="_blank" href=""><span>教师</span></a></li>-->
	  <li><a  href="http://it.haitianyuan.com/teacher/search/search.php"><span>教师查询</span></a></li>
	  <li><a  href="http://it.haitianyuan.com/teacher/search/fsearch.php"><span>基金查询</span></a></li>
	  <li><a target="_blank" href="http://it.haitianyuan.com/teacher/introduction/introduction.php"><span>介绍</span></a></li>
	  <li><a  href="http://it.haitianyuan.com"><span>海天园</span></a></li>
	  <div class='loginfo'>
	  <?php
		if(!isset($_SESSION['uid'])){
			echo "<a  href=\"http://it.haitianyuan.com/teacher/register/login.php\"><span>登录</span></a>".
				"<a  href=\"http://it.haitianyuan.com/teacher/register/register.php\"><span>注册</span></a>";
		}
		else{
			echo "<a  href=\"http://it.haitianyuan.com/teacher/register/logout.php\"><span>退出登录</span></a>";
		}
	  ?>
	  </div>
	</ul>

			
</div>