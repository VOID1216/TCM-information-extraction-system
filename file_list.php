<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8">
		<title>信息抽取平台</title>
	</head>
	<link rel="stylesheet" type="text/css" href="CSS/file_list.css" />
	<script src="JS/Jquery.js"></script>
	<body>
		<div>
			<div id="header" class="header"><!-- 网页最上方TOP-->
				<div class="headerTitlepic"><!-- 网页最上方TOP左侧LOGO位置 -->
					<img src="image/webtitle.png" width="380px" height="50px" style="margin: auto;position: relative;top: 0;left: 20px;bottom: 0;right: 0;"/><!--LOGO图片-->
				</div>
				<div id="headerUser" class="headerUser">
					<img src="image/icon/user.png" height="45px" width="45px"/>
                    <div style="text-align: center;margin-top: 0px ; position: absolute; top:10px;left:50px;" >李应龙</div>
				</div><!-- 网页最上方TOP右侧用户位置 -->
			</div>
			<div id="leftMenu" class="leftMenu"><!-- 网页左侧Left跳转功能栏 -->
				<ul class="leftMenulist">
                    <li onclick="pageJump('file_list')"><span style="display: block; text-align: center; line-height: 50px; color: white; ">文章列表</span></li><!-- 按钮内容 -->
                    <li onclick="pageJump('')"><span style="display: block; text-align: center; line-height: 50px; color: white; ">实体标签</span></li>
                    <li onclick="pageJump('')"><span style="display: block; text-align: center; line-height: 50px; color: white; ">因果标签</span></li>
                    <li onclick="pageJump('user_admin')"><span style="display: block; text-align: center; line-height: 50px; color: white; ">用户管理</span></li>
                    <li onclick="pageJump('')"><span style="display: block; text-align: center; line-height: 50px; color: white; ">日志</span></li>
                    <li onclick="pageJump('')"><span style="display: block; text-align: center; line-height: 50px; color: white; ">数据备份站</span></li>
				</ul>
			</div>
			<div style="">
				<div class="operateContainer"><!-- 主要操作区上方的长条操作板块样式 -->
				<div id="operateContainerBlock">
						<div style="display: inline-block;position: relative; float: right; margin-right: 22px;margin-top: 10px;">
							<form action="" method="post" style="position: relative;float: right;margin-left: 10px;">
								<div>
									<input id="fileRearch" type="text" style="" />
									<input id="fileRearch" type="button" style="margin-left: 10px;margin-right: 30px;" value="搜索" />
									<input id="fileadd" type="button" style="margin-left: 10px;margin-right: 30px;" value="添加文件" />
								</div>
							</form>
							<span style="font-size: 14px;">分类</span>
							<select>
								<option>全部</option>
								<option>class1</option>
								<option>class2</option>
								<option>class3</option>
							</select>
						</div>
				</div>
				</div>
					<div class="mainContainer"><!-- 页面调转菜单栏右侧的主要操作区样式 -->
						<div id="fileListitemGroup">
							<div class="fileListitem"><!-- 文件列表，右边有按钮“编辑”、“删除” -->
								<div style="position: relative; float: left;width: 50px;height: 40px;border: #00ff00 solid 1px;"><!-- 装入文件图片 -->
									<img src="image/icon/txt_icon.png" height="30px" width="30px" style="margin: auto;position: absolute;top: 0;left: 0;bottom: 0;right: 0;" alt="">
								</div>
								<span style="margin-top: 14px;position: relative;float: left;font-size: 12px">大医金阙论.txt</span>
								<div id="fileListitemButtongroup">
									<input type="button" id="fileListitemEdit" value="编辑" onclick="pageJump('file_annotation')"/>
									<input type="button" id="fileListitemDel" value="删除" />
								</div>
								<span id="fileTimeinfoFont">上次标注时间15:22 2023-03-12</span>
							</div>
							<div class="fileListitem"><!-- 文件列表，右边有按钮“编辑”、“删除” -->
								<div style="position: relative; float: left;width: 50px;height: 40px;border: #00ff00 solid 1px;"><!-- 装入文件图片 -->
									<img src="image/icon/txt_icon.png" height="30px" width="30px" style="margin: auto;position: absolute;top: 0;left: 0;bottom: 0;right: 0;">
								</div>
								<span style="margin-top: 14px;position: relative;float: left;font-size: 12px">本草纲目(缩短宽度div会挤下去【未解决】).txt</span>
								<div id="fileListitemButtongroup">
									<input type="button" id="fileListitemEdit" value="编辑" onclick="pageJump('file_annotation')"/>
									<input type="button" id="fileListitemDel" value="删除"/>
								</div>
								<font id="fileTimeinfoFont">上次标注时间16:10 2023-03-12</font>
							</div>
						</div>
					</div>
			</div>
		</div>
	</body>
	<script>
		function pageJump(src){
            if (src == ""){
                alert("页面正在开发，敬请期待！");
            }else {
                location.href=src+".php";
            }
        }
        function fileEdit(){

        }
	</script>
</html>