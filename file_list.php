<?php
header("content-type:text/html; charset=UTF-8");
$link = mysqli_connect("localhost", "root", "", "smart_annotation");
$queryString = "select id,name,set_time from assignment;";
$rs = mysqli_query($link, $queryString);
echo mysqli_error($link);
$i=0;
$row=false;
$rows=0;
while (($row = mysqli_fetch_assoc($rs))!=false){
    $rows[$i]=$row;
    $name[$i]=$row['name'];
    $id[$i]=$row['id'];
    $time[$i]=$row['set_time'];
    $i++;
}
$arrayLength = count($rows);
$i=0;
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>信息抽取平台</title>
</head>
<link rel="stylesheet" type="text/css" href="CSS/file_list.css"/>
<script src="JS/Jquery.js"></script>
<body>
<div>
    <div id="header" class="header"><!-- 网页最上方TOP-->
        <div class="headerTitlepic"><!-- 网页最上方TOP左侧LOGO位置 -->
            <img src="image/webtitle.png" width="380px" height="50px"
                 style="margin: auto;position: relative;top: 0;left: 20px;bottom: 0;right: 0;"/><!--LOGO图片-->
        </div>
        <div id="headerUser" class="headerUser">
            <img src="image/icon/user.png" height="45px" width="45px"/>
            <div style="text-align: center;margin-top: 0px ; position: absolute; top:10px;left:50px;">李应龙</div>
        </div><!-- 网页最上方TOP右侧用户位置 -->
    </div>
    <div id="leftMenu" class="leftMenu"><!-- 网页左侧Left跳转功能栏 -->
        <ul class="leftMenulist">
            <li onclick="pageJump('file_list')"><span
                        style="display: block; text-align: center; line-height: 50px; color: white; ">文章列表</span>
            </li><!-- 按钮内容 -->
            <li onclick="pageJump('')"><span
                        style="display: block; text-align: center; line-height: 50px; color: white; ">实体标签</span>
            </li>
            <li onclick="pageJump('')"><span
                        style="display: block; text-align: center; line-height: 50px; color: white; ">因果标签</span>
            </li>
            <li onclick="pageJump('user_admin')"><span
                        style="display: block; text-align: center; line-height: 50px; color: white; ">用户管理</span>
            </li>
            <li onclick="pageJump('')"><span
                        style="display: block; text-align: center; line-height: 50px; color: white; ">日志</span></li>
            <li onclick="pageJump('')"><span
                        style="display: block; text-align: center; line-height: 50px; color: white; ">数据备份站</span>
            </li>
        </ul>
    </div>
    <div style="">
        <div class="operateContainer"><!-- 主要操作区上方的长条操作板块样式 -->
            <div id="operateContainerBlock">
                <div style="float: right;height: 45px;margin-top: 10px">
                    <form id="formUpload" name="formUpload" action="/action/upload.php" method="post"
                          target="iframe1" enctype="multipart/form-data">
                        <input type="file" id="myFile" name="myFile">
                        <input type="submit" id="btnUpload" name="btnUpload"
                               style="margin-left: 10px;margin-right: 30px;" value="添加文件" onclick="upload()">
                    </form>
                </div>
                <div style="display: inline-block;position: relative; float: right; margin-right: 22px;margin-top: 10px;height: 45px">
                    <div style="position: relative;float: right;margin-left: 10px;">
                        <input id="fileRearch" type="button" style="margin-left: 10px;margin-right: 30px;"
                               value="搜索"/>
                    </div>
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
<!--                根据数据库内数据DOM动态加载-->
            </div>
        </div>
    </div>
</div>
<iframe name="iframe1" id="iframe1" src="action/upload.php"></iframe>
</body>
<script type="text/javascript">
    const jsonStrName = '<?php echo json_encode($name,JSON_UNESCAPED_UNICODE);?>';
    jsonName=JSON.parse(jsonStrName);
    const jsonStrTime = '<?php echo json_encode($time,JSON_UNESCAPED_UNICODE);?>';
    jsonTime=JSON.parse(jsonStrTime);
    const jsonStrId = '<?php echo json_encode($id,JSON_UNESCAPED_UNICODE);?>';
    jsonId=JSON.parse(jsonStrId);
    const fileListitemGroup = $("#fileListitemGroup");
    for (let i = 0; i < <?php echo $arrayLength;?>; ++i) {
        let objDiv1=$("<div>",{
            class: "fileListitem"
        });
        objDiv1.appendTo(fileListitemGroup);
        let objDiv2=$("<div>",{
            css:{
                position: "relative",
                float: "left",
                width: "50px",
                height: "40px",
                border: "1px solid #00ff00"
            }
        });
        objDiv2.appendTo(objDiv1);
        let objImg=$("<img>",{
            alt:"",
            src:"image/icon/txt_icon.png",
            height:"30px",
            width:"30px",
            css: {
                margin: "auto",
                position: "absolute",
                top: 0,
                left: 0,
                bottom: 0,
                right: 0
            }
        });
        objImg.appendTo(objDiv2);
        let objSpan=$("<span>",{
            css:{
                position: "relative",
                float: "left",
                fontsize: "12px",
                marginTop: "14px"
            }
        });
        objSpan.html(jsonName[i]);
        objSpan.appendTo(objDiv1);
        let objDiv3=$("<div>",{
            id:"fileListitemButtongroup"
        });
        objDiv3.appendTo(objDiv1);
        let objSpanTime=$("<span>");
        objSpanTime.appendTo(objDiv3);
        objSpanTime.html('创建时间:'+jsonTime[i]+'   ');
        let objInputEdit=$("<input>",{
            type: "button",
            value: "编辑"
        });
        objInputEdit.appendTo(objDiv3);
        objInputEdit.click(function (){
            location.href="file_annotation.php?id="+jsonId[i];
        })
        let objInputDel=$("<input>",{
            type: "button",
            value: "删除"
        });
        objInputDel.appendTo(objDiv3);
    }

    function upload() {
        $("#formUpload").submit();
    }
</script>
</html>