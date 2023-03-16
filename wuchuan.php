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
					文件：龙的秘密
				</div>
					<div class="box"><!-- 作用是加上个滚动条 -->
					<svg style=" background-color:lavender;width: 100%;height: 1200px;" xmlns="http://www.w3.org/2000/svg"><!-- svg框，需要改变 height 属性增加滚动条的量 -->
						<rect width="51" height="17" x="72" y="153" fill="red" rx="5" ry="5" />
						<text style="white-space: pre; overflow-wrap: normal;" x="0" y="15" fill="black"><!-- svg框，需要改变 height 属性增加滚动条的量 -->
							<tspan x="10" dy="51">黑子研究与分析</tspan>
							<tspan x="10" dy="51">作者 孫吴氚</tspan>
							<tspan x="10" dy="51">龙哥是个小黑子，到底应该如何实现。 龙哥是个小黑子因何而发生?带着这些问题，我们来审视一下龙哥这个小黑子。 达尔文在不经意间这样说过，敢于浪费哪怕一个钟头时间的人，说明他还不懂得珍惜生命的全部价值。</tspan>
							<tspan x="10" dy="51">这启发了我， 而这些并不是完全重要，更加重要的问题是， 洛克曾经说过，学到很多东西的诀窍，就是一下子不要学很多。这句话语虽然很短，但令我浮想联翩。 白哲特在不经意间这样说过，坚强的信念能赢得强者的心，并使他们变得更坚强。</tspan>
							<tspan x="10" dy="51">我们还要更加慎重的审视这个问题： 生活中，若龙哥是个小黑子出现了，我们就不得不考虑它出现了的事实。 一般来讲，我们都必须务必慎重的考虑考虑。 既然如何， 我们不得不面对一个非常尴尬的事实</tspan>
							<tspan x="10" dy="51">那就是， 龙哥是个小黑子，发生了会如何，不发生又会如何？就我个人来说，龙哥是个小黑子对我的意义，不能不说非常重大。 黑格尔在不经意间这样说过，只有永远躺在泥坑里的人，才不会再掉进坑里。</tspan>
						</text>
					</svg>
					</div>
			</div>
		</div>
	</body>
	<script>
	</script>
</html>