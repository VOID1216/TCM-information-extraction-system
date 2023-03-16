<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>信息抽取平台</title>
	</head>
	<!-- top 是顶部长条 -->
	<!-- left 左边的跳转栏 -->
	<!-- logo 上方TOP左侧放LOGO的地方 -->
	<!-- user 上方TOP右侧放用户的地方 -->
	<!-- box SVG文本外面的div CSS样式,目的是通过overflow是加上一个滚动条 -->
	<!-- list li 左侧跳转栏里面的按钮CSS样式 -->
	<!-- list li:hover 左侧跳转栏里面的按钮CSS样式,鼠标移上去变色效果 -->
	<!-- list li:active 左侧跳转栏里面的按钮CSS样式,鼠标点击后变色效果 -->
	<style>
		
		.top{
			background-color: #6495ED;
			
			width: max-content;
			height: 80px;
			position: relative;
			top: 0px;
			min-width: 100%;
		}
		
		.left{
			width: 200px;
			border-radius: 10px;
			height: calc(100vh - 116px);
			position: relative;
			float: left;
			margin-top: 5px;
			border: #ff0000 1px solid;
			background-color: #6495ED;
		}
		.logo{
			border: 1px solid #ff0000;
			width: 200px ;
			height: 50px;
			float: left;
			position: relative;
			margin: 10px;
		}
		
		.user{
			border: 1px solid #ff0000;
			width: 200px ;
			height: 50px;
			float: right;
			position: relative;
			margin: 10px;
		}
		
		.box {
			width: calc(100% - 295px);
			padding: 20px;
			height: calc(100vh - 216px);
			float: left;
			position: relative;
			border: solid 1px #ff0000;
			margin-top: 20px;
			margin-left: 25px;
			padding: 10px;
			overflow: scroll;
		}
		.file_name{
			width: calc(100% - 295px);
			height:45px;
			border: #ff0000 solid 1px;
			position: relative;
			float: left;
			margin-left: 25px;
			margin-top:16px ;
			padding-left: 10px;
			padding-right: 10px;
		}
		.list{
			margin-top: 80px;
			padding: 0px;
			list-style-type: none;
		}
		.list li{
			list-style: none;
			background-color: #6495ED;
			position: relative;
			height: 50px;
		}
		
		.list li:hover{
			background-color: #ff0000;
		}
		
		.list li:active{
			background-color: #00ff00;
		}
		text_title{
			background-color: #ff0000;
		}
	</style>
	<body>
		<div>
			<div id="Top" class="top"><!-- 网页最上方TOP-->
				<div id="Top_left" class="logo"><!-- 网页最上方TOP左侧LOGO位置 -->
					<img src="LOGO.png" width="120px" height="50px" style="margin: auto;position: absolute;top: 0;left: 0;bottom: 0;right: 0;"/><!--LOGO图片-->
				</div>
				<div id="Top_right" class="user">
					<img src="user.png" height="45px" width="45px"/>李应龙
				</div><!-- 网页最上方TOP右侧用户位置 -->
			</div>
			<div id="Leftlist" class="left"><!-- 网页左侧Left跳转功能栏 -->
				<ul class="list">
					<li><font color="white" style="margin-left: 42px;">文章列表</font></li><!-- 按钮内容 -->
					<li><font color="white" style="margin-left: 42px;">实体标签</font></li>
					<li><font color="white" style="margin-left: 42px;">因果标签</font></li>
					<li><font color="white" style="margin-left: 42px;">用户管理</font></li>
					<li><font color="white" style="margin-left: 42px;">日志</font></li>
					<li><font color="white" style="margin-left: 42px;">数据备份站</font></li>
				</ul>
			</div>	
			<div style="">
				<div class="file_name"><!-- 作用是加上文件信息 -->
					<div style="position: relative; float: left;width: 50px;height: 43px;border: #00ff00 solid 1px;"><!-- 装入文件图片 -->
						<img src="txt_icon.jpeg" height="30px" width="30px" style="margin: auto;position: absolute;top: 0;left: 0;bottom: 0;right: 0;">
					</div>
					<form action="" method="post">
						<input id="file_rearch" type="text" style="position: relative;float: left;" />
						<input id="file_rearch" type="button" style="position: relative;float: left;margin-left: 10px;margin-right: 30px;" value="搜索" />
					</form>
					分类<select>
						<option>all</option>
						<option>class1</option>
						<option>class2</option>
						<option>class3</option>
					</select>
				</div>
					<div class="box"><!-- 作用是加上个滚动条 -->
					
					</div>
			</div>
		</div>
	</body>
	<script>
		
	</script>
</html>