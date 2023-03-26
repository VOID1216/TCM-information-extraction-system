<?php
    header("content-type:text/html; charset=UTF-8");
    $textId=$_GET['id'];
    $link = mysqli_connect("localhost", "root", "", "smart_annotation");
    $queryString = "select name,text from assignment where id='$textId'";
    $rs = mysqli_query($link, $queryString);
    $row = mysqli_fetch_assoc($rs);
//    $result='{"data":{"id":1,"annotation":{"content":"1.首先创建form表单，设置input的type为file实现文件的上传，代码如下： 1.首先创建form表单，设置input的type为file实现文件的上传，代码如下： 2.然后写php脚本去实现上传文件的功能，代码如下： 1.首先创建form表单，设置input的type为file实现文件的上传，代码如下： 1.首先创建form表单，设置input的type为file实现文件的上传，代码如下： 2.然后写php脚本去实现上传文件的功能，代码如下： 1.首先创建form表单，设置input的type为file实现文件的上传，代码如下： 2.然后写php脚本去实现上传文件的功能，代码如下： 1.首先创建form表单，设置input的type为file实现文件的上传，代码如下： 2.然后写php脚本去实现上传文件的功能，代码如下： ———————————————— 版权声明：本文为CSDN博主「柒℡.」的原创文章，遵循CC 4.0 BY-SA版权协议，转载请附上原文出处链接及本声明。 原文链接：https://blog.csdn.net/weixin_47665578/article/details/124145222"}}}';
//    echo $row[0];
    $jsonText = json_decode($row['text'],true);
//    echo json_last_error();
    $article=$jsonText['data']['annotation']['content'];
    echo $row['name'];
    $length=100;//以汉字长度为标准（多少个汉字长度）
    $articleArray=contentSplit($article,$length);
    function contentSplit($wenzhang,$length)
    {
        //函数作用是将内容排版，返回一个切割了文章内容的字符串数组
        //17个数字或小写字母相当于10个汉字 15个大写字母相当于10个汉字 1数字=10/17.5汉字 1大字=10/15汉字 1汉字=1汉字
        //length是一排的汉字标准长度
        $lastlocation=0;
        $splitnum=0;
        $templength=0;
        $wenzhangarray=array();
        $codestr="l~!@?<>#$%^&1234567890abcdefghijklmnopqrstuvwxyz";//第一个L不要删
        $codestr1="*()[]{}/\.·,'; ";//最后有个空格
        $codestr2="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        for($i=0;$lastlocation<mb_strlen($wenzhang,"utf-8");$i++,$templength=0){
            //echo (strpos($codestr,mb_substr($wenzhang,$i,1,"utf-8")))?"Yes":"No";
            for($j=$lastlocation;($templength<=$length);$j++){
                if($j<mb_strlen($wenzhang,"utf-8")&&strpos($codestr,mb_substr($wenzhang,$j,1,"utf-8"))){
                    $templength=$templength+(10/18);//数字及小写字母,可能需要调整10/18 6/18 10.5/15
                }else if($j<mb_strlen($wenzhang,"utf-8")&&strpos($codestr1,mb_substr($wenzhang,$j,1,"utf-8"))){
                    $templength=$templength+(6/18);//括号等小型字符
                }else if($j<mb_strlen($wenzhang,"utf-8")&&strpos($codestr2,mb_substr($wenzhang,$j,1,"utf-8"))){
                    $templength=$templength+(10.5/15);//大写字符
                }else{
                    $templength=$templength+1;
                    //echo $templength;
                }
                $splitnum=$j-$lastlocation;
            }
            $wenzhangarray[$i]=mb_substr($wenzhang,$lastlocation,$splitnum,"utf-8");
            $lastlocation=$lastlocation+$splitnum;
        }
        return $wenzhangarray;
    }
?>

<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<title>信息抽取平台</title>
	</head>
	<link rel="stylesheet" type="text/css" href="CSS/file_annotation.css" />
	<script src="JS/Jquery.js"></script>
	<body>
		<div>
			<div id="header" class="header"><!-- 网页最上方TOP-->
                <div class="headerTitlepic"><!-- 网页最上方TOP左侧LOGO位置 -->
                    <img src="image/webtitle.png" width="380px" height="50px" style="margin: auto;position: relative;top: 0;left: 20px;bottom: 0;right: 0;"/><!--LOGO图片-->
                </div>
                <div id="headerUser" class="headerUser">
                    <img src="image/icon/user.png" height="45px" width="45px"/>
                    李应龙
                </div><!-- 网页最上方TOP右侧用户位置 -->
			</div>
			<div id="leftMenu" class="leftMenu"><!-- 网页左侧Left跳转功能栏 -->
				<ul class="leftMenulist">
                    <li onclick="pageJump('file_list')"><span style="display: block; text-align: center; line-height: 50px; color: white; ">文章列表</span></li><!-- 按钮内容 -->
                    <li onclick="pageJump('user_admin')"><span style="display: block; text-align: center; line-height: 50px; color: white; ">用户管理</span></li>
                    <li onclick="pageJump('')"><span style="display: block; text-align: center; line-height: 50px; color: white; ">日志</span></li>
                    <li onclick="pageJump('')"><span style="display: block; text-align: center; line-height: 50px; color: white; ">数据备份站</span></li>
				</ul>
			</div>	
			<div style="">
				<div class="fileInfocontainer"><!-- 作用是加上文件信息 -->
					<div style="position: relative; float: left;width: 50px;height: 43px;border: #00ff00 solid 1px;"><!-- 装入文件图片 -->
						<img src="image/icon/txt_icon.png" height="30px" width="30px" style="margin: auto;position: absolute;top: 0;left: 0;bottom: 0;right: 0;">
					</div>
					<span style=""><?php echo $row['name']?></span>
				</div class="fileInfocontainer">
                <div class="labelInfocontainer">
                        <div class="label_box">
                            实体标签：
                            <span class="label_nav">默认标签_1</span>
                            <span class="label_nav">默认标签_2</span>
                            <span class="label_nav">默认标签_3</span>
                            <span class="label_nav">默认标签_4</span>
                            <span class="label_nav">默认标签_5</span>
                            <span class="label_nav">默认标签_5</span>
                            <span class="label_nav">默认标签_5</span>
                            <span class="label_nav">默认标签_5</span>
                            <span class="label_nav">默认标签_5</span>
                            <span class="label_nav">默认标签_5</span>
                            <span class="label_nav">默认标签_5</span>
                            <span class="label_nav">默认标签_5</span>
                            <span class="label_nav">默认标签_5</span>
                            <span class="label_nav">默认标签_5</span>
                            <span class="label_nav">默认标签_5</span>
                            <span class="label_nav">默认标签_5</span>
                            <span class="label_nav">默认标签_5</span>
                            <span class="label_nav">默认标签_5</span>
                            <span class="label_nav">默认标签_5</span>
                            <span class="label_nav">默认标签_5</span>
                            <span class="label_nav">默认标签_5</span>
                            <span class="label_nav">默认标签_5</span>
                            <span class="label_nav">默认标签_5</span>
                            <span class="label_nav">默认标签_5</span>
                            <span class="label_nav">默认标签_5</span>
                            <span class="label_nav">默认标签_5</span>
                            <span class="label_nav">默认标签_6</span>
                            <span class="label_nav">默认标签_7</span>
                            <span class="label_nav">默认标签_8</span>
                            <span class="label_nav">默认标签_9</span>
                            <button id="add_substance" name="add_substance" class="addLabel_button"  >添加实体标签</button>
                        </div>
                        <div class="label_box" ">
                            关系标签：
                            <span class="label_nav">默认标签</span>
                            <span class="label_nav">默认标签</span>
                            <span class="label_nav">默认标签</span>
                            <span class="label_nav">默认标签</span>
                            <span class="label_nav">默认标签</span>
                            <span class="label_nav">默认标签</span>
                            <span class="label_nav">默认标签</span>
                            <span class="label_nav">默认标签</span>
                            <span class="label_nav">默认标签</span>
                            <span class="label_nav">默认标签</span>
                            <span class="label_nav">默认标签</span>
                            <span class="label_nav">默认标签</span>
                            <span class="label_nav">默认标签</span>
                            <span class="label_nav">默认标签</span>
                            <span class="label_nav">默认标签</span>
                            <span class="label_nav">默认标签</span>
                            <span class="label_nav">默认标签</span>
                            <span class="label_nav">默认标签</span>
                            <span class="label_nav">默认标签</span>
                            <span class="label_nav">默认标签</span>
                            <span class="label_nav">默认标签</span>
                            <span class="label_nav">默认标签</span>
                            <span class="label_nav">默认标签</span>
                            <span class="label_nav">默认标签</span>
                            <span class="label_nav">默认标签</span>
                            <span class="label_nav">默认标签</span>
                            <span class="label_nav">默认标签</span>
                            <button id="add_relation" name="add_relation" class="addLabel_button"  >添加关系标签</button>
                        </div>
                </div>
					<div id="text" class="svgMaincontainer"><!-- 作用是加上个滚动条 -->
                        <svg style=" background-color:lavender;width: 1642px;height: 1200px;" xmlns="http://www.w3.org/2000/svg"><!-- svg框，需要改变 height 属性增加滚动条的量,width固定长度 -->
                            <g><rect width="51" height="17" x="72" y="153" fill="red" rx="5" ry="5" /></g>
                            <text style="white-space: pre; overflow-wrap: normal;" x="0" y="15" fill="black"><!-- svg框，需要改变 height 属性增加滚动条的量 -->
                            <?php
                                for($i=0;$i<Count($articleArray);$i++)
                                {
                                echo "<tspan x='10' dy='51'>$articleArray[$i]</tspan>";
                                }
                            ?>
                            </text>
                        </svg>
					</div>
			</div>
		</div>
	</body>
	<script>

	</script>
</html>