<?php
function printResult($right,$pid,$table){
	$q = "select refurl from $table where pid=$pid";
	//echo $q;
	$rst = mysql_query($q) or die(mysql_error());
	if($f=mysql_fetch_array($rst)){
		$url = $f['refurl'];	
	}
	mysql_free_result($rst);
	
	if($right == 5 || $right == 6)
		echo "<a target='_blank' href='".$url."'>查看</a>";
	else
		echo "—";
}

	mysql_select_db($TEACHER_DB,$link) or die(mysql_error());
	mysql_query("set names utf8");	
?>
<script type="text/javascript" src="../jquery.js"></script>
<script language="javascript">
//预览论文信息
function getPaperPreview(pid){
	//alert(pid);
	$.post("paperpreview.php",
		{
			pid:pid
		},
		function(json){
			//alert(json);
			var json = eval("("+json+")");
			setPreview(json);
		}
	);
}
//设置预览显示
function setPreview(data){
	var preview = $("#prv_mod");
	var p_title = $("#p_title");
	var p_content = $("#p_content");
	
	if(data.volume == "null")
		data.volume = "&nbsp;";
	if(data.num == "")
		data.num = "&nbsp;";
	else 
	    data.num = "("+data.num+")";
	
	var content="<p style='line-height:150%;margin:0 10px 10px 0;text-indent:2em;'>"+data.abstract+"</p>"+
				"<dt>作者信息：</dt><dd>"+data.author+"</dd>"+
				"<dt>作者单位：</dt><dd>"+data.authorunit+"</dd>"+
				"<dt>期刊：</dt><dd>"+data.cnjournal+"</dd>"+
				"<dt>英文刊名：</dt><dd>"+data.enjournal+"&nbsp;</dd>"+
				"<dt>年，卷(期)：</dt><dd>"+data.year+"&nbsp;"+data.volume+data.num+"</dd>"+
				"<dt>分类号：</dt><dd>"+data.catalognum+"</dd>"+
				"<dt>关键词：</dt><dd>"+data.keyword+"</dd>"+
				"<dt>基金项目：</dt><dd>"+data.foundation+"</dd>";
	//alert(content);
	p_content.html(content);
	p_title.empty();
	p_title.append(data.cntitle+"<a style='margin-left:50px;cursor:pointer' onclick='removePreview()' >关闭预览</a>");
	
	$("#detailpaperinfo").hide();
	preview.show();
}
//关闭预览
function removePreview(){
	var preview = $("#prv_mod");	//预览层
	preview.hide();
	$("#detailpaperinfo").show();
}

//页面的伸缩
function change(eid){
	//alert(eid+"*"+flag[eid]+"*"+element[eid]);
	flag[eid] = !flag[eid];
	var pdtitle = $("#papertitle"+eid);
	pdtitle.removeClass();
	if(flag[eid]){
		pdtitle.addClass("detailpaper_on");
		$(element[eid]).show();
	}
	else{
		pdtitle.addClass("detailpaper_off");
		$(element[eid]).hide();
	}
}
var element = new Array("#confirmyes","#confirmnot","#notconfirm");
var flag = new Array(true,false,false);	//true 展开显示 ；false 叠起不显示
</script>

<div id="middle">

<div id="detailpaperinfo" class="detailpaperinfo">
	<div id="papertitle0" class="detailpaper_on" onclick="change(0)">
		  <p style="margin-left:50px;font-weight:bold;">确认中文论文</p>
	</div>
	<div id="confirmyes" class="confirmyes">
		<table width="830px">
			<tr><th width="30px">序号</th><th>论文信息</th><th width="60px">万方页面</th><th width="60px">维普页面</th><th width="60px">知网页面</th>
			<th width="30px">预览</th></tr>
		
			<?php
				$query = "select * from paper where stid=$tid and cn=1 and (isright=5 or vipright=5 or cnkiright=5) order by date desc";
				$result = mysql_query($query) or die(mysql_error());
				
				$j=0;
				while($row = mysql_fetch_array($result)){
					$j++;
					echo "<tr><td>".$j."</td><td style='text-align:left'>";
					//得到论文作者
					$sql = "select tname from author where pid=".$row['id']." order by rank ";
					$rs = mysql_query($sql) or die(mysql_error($sql));
					if($r=mysql_fetch_array($rs))
						echo str_replace(","," ",$r['tname']);
					while($r=mysql_fetch_array($rs)){
						echo ",".str_replace(","," ",$r['tname']);
					}
					
					echo ".<a target='_blank' href='".$row['refurl']."'>".$row['title']."</a>";	//论文标题
					if($row['name'])	//期刊名
						echo ".".$row['name'];
					if($row['date'])
						echo ",".$row['date'];//日期
					if($row['volume'])
						echo ",".$row['volume'];
					if($row['num'])
						echo "(".$row['num'].")";
					if($row['page'])
						echo ":".$row['page'];
							
					echo "<span style='color:blue;margin-left:5px'>".$row['refnum']."</span></td><td>";
					
					//万方
					printResult($row['isright'],$row['id'],"wfdata");
					echo "</td><td>";
					//维普
					printResult($row['vipright'],$row['id'],'vipdata');
					echo "</td><td>";
					//知网
					printResult($row['cnkiright'],$row['id'],'cnkidata');
	
					echo "</td><td>";
					echo "<div style='cursor:pointer' onclick='getPaperPreview(".$row['id'].")'>预览</div>";
					echo "</td></tr>";
						
					mysql_free_result($rs);	
				}
				mysql_free_result($result);
				
			?>
		</table>
	</div>
	
	<div id="papertitle1" class="detailpaper_off" onclick="change(1)"><p style="margin-left:50px;font-weight:bold;">确认不是的中文论文</p></div>
	<div id="confirmnot" class="confirmnot">
		<table width="830px">
			<tr><th width="30px">序号</th><th>论文信息</th><th width="60px">万方页面</th><th width="60px">维普页面</th><th width="60px">知网页面</th>
			<th width="30px">预览</th></tr>
		
			<?php
				$query = "select * from paper where stid=$tid and cn=1 and (isright!=5 and vipright!=5 and cnkiright!=5) and (isright=6 or vipright=6 or
					cnkiright=6) order by date desc";
				$result = mysql_query($query) or die(mysql_error());
				
				$j=0;
				while($row = mysql_fetch_array($result)){
					$j++;
					echo "<tr><td>".$j."</td><td style='text-align:left'>";
					//得到论文作者
					$sql = "select tname from author where pid=".$row['id']." order by rank ";
					$rs = mysql_query($sql) or die(mysql_error($sql));
					if($r=mysql_fetch_array($rs))
						echo str_replace(","," ",$r['tname']);
					while($r=mysql_fetch_array($rs)){
						echo ",".str_replace(","," ",$r['tname']);
					}
					
					echo ".<a target='_blank' href='".$row['refurl']."'>".$row['title']."</a>";	//论文标题
					if($row['name'])	//期刊名
						echo ".".$row['name'];
					if($row['date'])
						echo ",".$row['date'];//日期
					if($row['volume'])
						echo ",".$row['volume'];
					if($row['num'])
						echo "(".$row['num'].")";
					if($row['page'])
						echo ":".$row['page'];
							
					echo "<span style='color:blue;margin-left:5px'>".$row['refnum']."</span></td><td>";
					
					//万方
					printResult($row['isright'],$row['id'],"wfdata");
					echo "</td><td>";
					//维普
					printResult($row['vipright'],$row['id'],'vipdata');
					echo "</td><td>";
					//知网
					printResult($row['cnkiright'],$row['id'],'cnkidata');
	
					echo "</td><td>";
					echo "<div style='cursor:pointer' onclick='getPaperPreview(".$row['id'].")'>预览</div>";
					echo "</td></tr>";
						
					mysql_free_result($rs);	
				}
				mysql_free_result($result);
				
			?>
		</table>
	</div>
	
	<div id="papertitle2" class="detailpaper_off" onclick="change(2)"><p style="margin-left:50px;font-weight:bold;">待确认的中文论文</p></div>
	<div id="notconfirm" class="notconfirm">
		<table width="830px">
			<tr><th width="30px">序号</th><th>论文信息</th><th width="60px">万方页面</th><th width="60px">维普页面</th><th width="60px">知网页面</th>
			<th width="30px">预览</th></tr>
		
			<?php
				$query = "select * from paper where stid=$tid and title != '' and cn=1 and (isright!=5 and vipright!=5 and cnkiright!=5) and (isright!=6 or vipright!=6 or
					cnkiright!=6) order by date desc";
				$result = mysql_query($query) or die(mysql_error());
				
				$j=0;
				while($row = mysql_fetch_array($result)){
					$j++;
					echo "<tr><td>".$j."</td><td style='text-align:left'>";
					//得到论文作者
					$sql = "select tname from author where pid=".$row['id']." order by rank ";
					$rs = mysql_query($sql) or die(mysql_error($sql));
					if($r=mysql_fetch_array($rs))
						echo str_replace(","," ",$r['tname']);
					while($r=mysql_fetch_array($rs)){
						echo ",".str_replace(","," ",$r['tname']);
					}
					
					echo ".<a target='_blank' href='".$row['refurl']."'>".$row['title']."</a>";	//论文标题
					if($row['name'])	//期刊名
						echo ".".$row['name'];
					if($row['date'])
						echo ",".$row['date'];//日期
					if($row['volume'])
						echo ",".$row['volume'];
					if($row['num'])
						echo "(".$row['num'].")";
					if($row['page'])
						echo ":".$row['page'];
							
					echo "<span style='color:blue;margin-left:5px'>".$row['refnum']."</span></td><td>";
					
					//万方
					printResult($row['isright'],$row['id'],"wfdata");
					echo "</td><td>";
					//维普
					printResult($row['vipright'],$row['id'],'vipdata');
					echo "</td><td>";
					//知网
					printResult($row['cnkiright'],$row['id'],'cnkidata');
	
					echo "</td><td>";
					echo "<div style='cursor:pointer' onclick='getPaperPreview(".$row['id'].")'>预览</div>";
					echo "</td></tr>";
						
					mysql_free_result($rs);	
				}
				mysql_free_result($result);
				
			?>
		</table>
	</div>
	
</div>

<!--预览区-->
<div id="prv_mod" class="paperpreview">
	<div id="p_title" class="p_title"></div>
	<div id="p_content" class="p_content"></div>
</div>
	
</div>