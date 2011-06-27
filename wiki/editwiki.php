<?php
/**用户编辑页面
*为了让所有老师都可编辑，使用uid,tid作为标识
*/
session_start();
include_once("../include/const.inc");
include_once("../include/functions.inc");

if(!isset($_GET['uid']))
	jumpback();
$uid = $_GET['uid'];

if(!isset($_SESSION['uid']))
	jumpback("只有登录用户才有权限编辑");
//正在登录的用户号
$userid = $_SESSION['uid'];

//查看是否uid已有对应的wiki，如有则读取显示
$query = "select * from wikiinfo where uid=$uid";
$result = mysql_query($query) or die(mysql_error());
$wikiinfo = "";
if($row=mysql_fetch_array($result)){
	$wikiinfo = $row['info'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="utf-8">
<head>	
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="Description" Content="有关教师个人信息、教师研究信息、教师活动信息等内容，高校教师的更直接、高集成、全方位、多角度的信息展示平台">
<meta name="description" content="university teacher information display">
<meta name="keywords" content="高校教师,研究信息,社会网络,用户编辑">
<meta name="author" content="Wendell">
<link rel="stylesheet" href="css/wiki.css" type="text/css" media="all" />
<link rel="stylesheet" href="../css/hf.css" type="text/css" media="all" />
<title>高校教师人物网——用户编辑</title>

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
		<!-- TinyMCE -->
<script type="text/javascript" src="../js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
		//language: "zh_cn_utf8"

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
	//	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : false,
		//theme_advanced_resizing : true,
		//language : "en", 
		
/* 		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		], */

	
	});
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
		

		<!-- /TinyMCE -->
		<div id="middle">
			<form method="post" action="savewiki.php">
				<input type="hidden" name="uid" value="<?PHP echo $uid;?>">
				<input type="hidden" name="userid" value="<?PHP echo $userid;?>">
				<div>
					<h3>用户编辑页面</h3>

					<p>
						请大家共同参与，编辑熟悉的老师信息！
					</p>

					<!-- Gets replaced with TinyMCE, remember HTML in a textarea should be encoded -->
					<div>
						<textarea id="elm" name="wikiinfo" class="wiki">
							<?PHP echo $wikiinfo; ?>
						</textarea>
					</div>

					<input type="submit" name="save" value="提交" />
					<input type="reset" name="reset" value="重置" />
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

