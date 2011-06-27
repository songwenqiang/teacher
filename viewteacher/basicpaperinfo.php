 <div id="middle">
<?php
	$cn_num = 0;	//中文论文数
	$confim_cn_num = 0;	//确认中文论文数
	
	mysql_select_db($TEACHER_DB,$link) or die(mysql_error());
	
	//总的中文论文数
	$query = "select count(*)  as  cn_num from paper where cn=1 and stid=".$tid;
	$result = mysql_query($query) or die(mysql_error());
	if($row = mysql_fetch_array($result)){
		$cn_num = $row['cn_num'];
	}
	
	//确认中文论文数
	$query = "select count(*) as confim_yes_num from paper where (isright=5 or vipright=5 or 
			 cnkiright=5) and cn=1 and stid=".$tid;
	$result = mysql_query($query) or die(mysql_error());
	if($row = mysql_fetch_array($result))
		$confim_yes_num = $row['confim_yes_num'];
	
	/* //论文时间跨度
	$query = "select date,count(*) as num from paper where paper.stid=$tid group by date";
	$result = mysql_query($query) or die(mysql_error());
	while($row=mysql_fetch_array($result)){
		if(!$row['date'])	//日期为空
			continue;
		$years[] = $row['date'];
		$pnum[] = $row['num'];
	} */
?>
<div class="middlebox">
	<div class="title">
		论文概况
	</div>
	<div class="content">
		<div class="paper_desc">
			<?php			
			  echo "<span>从网络检索到的中文论文总数为".$cn_num.",其中能够确认的论文数为".$confim_yes_num."。</span>";
			  echo "<img src='draw.php?tid=".$tid."' border=0 align=center width=400 height=200>";
			  echo "<p style='margin-left:160px;font-size:10px'>中文论文发表数量趋势图</p>";
			?>
		</div>
	</div>
</div>


<script type="text/javascript" src="../js/jquery.js"></script>
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
	
	p_content.html(content);
	p_title.empty();
	p_title.append(data.cntitle+"<a style='margin-left:50px;cursor:pointer' onclick='removePreview()' >关闭预览</a>");
	
	$(".middlebox").hide();
	preview.show();
}
//关闭预览
function removePreview(){
	var preview = $("#prv_mod");	//预览层
	preview.hide();
	$(".middlebox").show();
}
</script>

<div class="middlebox">
	<div class="title">
		论文引用
	</div>
	<div class="content">
		<table width="660px">
			<tr><th width="30px">序号</th><th>论文信息</th><th width="60px">被引用数</th><th width="30px">预览</th></tr>
		
			<?php
				$query = "select * from paper where stid=$tid and cn=1 and (isright=5 or vipright=5 or cnkiright=5) order by refnum desc limit 5";
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
							
					echo "</td><td>";
					
					//引用信息
					echo $row['refnum'];
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

<div class="middlebox">
	<div class="title">
		论文合作者 top 5
	</div>
	<div class="content">
		<table width="300px" style="text-align:center">
			<tr><th width="30px">序号</th><th>合作者</th><th width="80px" >合作论文数</th><th width="30px">查询</th></tr>
		<?php
			$query = "select tname,count(*) as num from author,paper where author.stid=$tid and paper.id=pid and cn=1 group by tname order by count(*) desc limit 6";
			$result = mysql_query($query) or die(mysql_error());
			
			$i = 0;
			$row=mysql_fetch_array($result);	//过滤掉第一个，作者自己
			while($row=mysql_fetch_array($result)){
				echo "<tr><td>".(++$i)."</td><td>".$row['tname']."</td><td>".$row['num']."</td><td>待做</td>";
			}
		?>
		</table>
	</div>
</div>

<div class="middlebox">
	<div class="title">
		基金项目
	</div>
	<div class="content">
		<table width="650px" style="text-align:center">
			<tr><th width="30px">序号</th><th>基金名称</th><th width="30px">年份</th><th width="60px">论文数量</th></tr>
		<?php
			/*
			$query = "select wfdata.foundation as wf,vipdata.foundation as vf,cnkidata.foundation as cf,wfdata.year as year from cnkidata,vipdata,wfdata,paper where 
			cnkidata.pid=vipdata.pid and vipdata.pid=wfdata.pid and cnkidata.tid=$tid and paper.id=cnkidata.pid and (paper.isright=5 or vipright=5 or cnkiright=5) 
			order by year desc limit 10";
			$result = mysql_query($query) or die(mysql_error());
			
			while($row=mysql_fetch_array($result)){
				if($row['vf'] != null && $row['vf'] != 'null'){
					$foundation = $row['vf'];
				}
				else if($row['cf'] != null && $row['cf'] != 'null')
					$foundation = $row['cf'];
				else if($row['wf'] != null && $row['cf'] != 'null'){
					$foundation = $row['wf'];
				}
				
				echo "<tr><td>".(++$i)."</td><td>$foundation</td><td>".$row['year']."</td>";
			}
			*/
			$query = "select foundation,year,count(*) as num from vipdata,paper where tid=$tid and paper.id=pid and vipright=5 
				group by foundation order by count(*) desc limit 10";
			//echo $query;
			$result = mysql_query($query) or die(mysql_error());
			
			$i = 0;
			while($row=mysql_fetch_array($result)){		
				$foundation = $row['foundation'];
				
				if($foundation != null && $foundation != "null")
					echo "<tr><td>".(++$i)."</td><td>$foundation</td><td>".$row['year']."</td><td>".$row['num']."</td>";
			}
			
		?>
		</table>
	</div>
</div>

<div class="middlebox">
	<div class="title">
		期刊杂志
	</div>
	<div class="content">
		<table width="650px" style="text-align:center">
			<tr><th width="30px">序号</th><th>名称</th><th width="30px">数量</th></tr>
			<?php
				$query = "select name,count(*) as num from paper where stid=$tid group by name order by count(*) desc limit 11";
				$result = mysql_query($query) or die(mysql_error());
				
				$i = 0;
				while($row=mysql_fetch_array($result)){
					if($row['name'] != null)
						echo "<tr><td>".(++$i)."</td><td>".$row['name']."</td><td>".$row['num']."</td></tr>";
				}
			?>
		</table>
	</div>
</div>

<div class="middlebox">
	<div class="title">
		论文关键词统计
	</div>
	<div class="content">
		<table width="650px" style="text-align:center">
			<tr><th width="30px">序号</th><th>关键词</th><th width="30px">数量</th></tr>
			<?php
				$query = "select keyword,count(*) as num from keyword where tid=$tid group by keyword order by count(*) desc limit 5";
				$result = mysql_query($query) or die(mysql_error());
				
				$i = 0;
				while($row=mysql_fetch_array($result)){
					if($row['keyword'] != null)
						echo "<tr><td>".(++$i)."</td><td>".$row['keyword']."</td><td>".$row['num']."</td></tr>";
				}
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

  <!--right-->
<div id="right">  
</div>