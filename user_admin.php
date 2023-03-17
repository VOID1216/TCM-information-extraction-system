<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>信息抽取平台</title>
</head>
<link rel="stylesheet" type="text/css" href="CSS/user_admin.css" />
<script src="JS/Jquery.js"></script>
<body>
<div>
    <div id="header" class="header"><!-- 网页最上方TOP-->
        <div class="headerTitlepic"><!-- 网页最上方TOP左侧LOGO位置 -->
            <img src="image/webtitle.png" width="380px" height="50px" style="margin: auto;position: relative;top: 0;left: 20px;bottom: 0;right: 0;"/><!--LOGO图片-->
        </div>
        <div id="headerUser" class="headerUser">
            <img src="image/icon/user.png" height="45px" width="45px" alt=""/>
            <div style="text-align: center;margin-top: 0px ; position: absolute; top:10px;left:50px;" >李应龙</div>
        </div><!-- 网页最上方TOP右侧用户位置 -->
    </div>
    <div id="leftMenu" class="leftMenu"><!-- 网页左侧Left跳转功能栏 -->
        <ul class="leftMenulist">
            <li onclick="pageJump('file_list')"><span style="display: block; text-align: center; line-height: 50px; color: white;">文章列表</span></li><!-- 按钮内容 -->
            <li><span style="display: block; text-align: center; line-height: 50px; color: white; ">实体标签</span></li>
            <li><span style="display: block; text-align: center; line-height: 50px; color: white; ">因果标签</span></li>
            <li onclick="pageJump('user_admin')"><span style="display: block; text-align: center; line-height: 50px; color: white; ">用户管理</span></li>
            <li><span style="display: block; text-align: center; line-height: 50px; color: white; ">日志</span></li>
            <li><span style="display: block; text-align: center; line-height: 50px; color: white; ">数据备份站</span></li>
        </ul>
    </div>
    <div style="">
        <div class="operateContainer"><!-- 主要操作区上方的长条操作板块样式 -->
            <div id="operateContainerallBlock">
                <div id="operateContainerleftBlock" >
                    <div style="position: relative; float: left;width: 28px;height: 28px;border: #00ff00 solid 1px;margin: 6px;">
                        <input id="ck-all" type="checkbox" style="margin: auto;position: absolute;top: 0;left: 0;bottom: 0;right: 0;margin:5px" onclick="checkboxIschecked(this)"/>
                    </div>全选
                    <input id="userDel" type="button" value="删除用户" style="margin: 10px;"/>
                </div>
                <div id="operateContainermiddleBlock" >
                    用户名<input id="userNameinput" type="text" style="margin: 10px;"/>密码<input id="userPasswordinput" type="text" style="margin: 10px;"/>
                    权限<select style="margin-left:0px"><!-- 向右调整一下 -->
                        <option>一级管理权限</option>
                        <option>二级管理权限</option>
                        <option>三级管理权限</option>
                        <option>游客用户权限</option>
                    </select>
                    <input id="userAddandEdit" type="button" style="margin-left: 10px;margin-right: 30px;" value="添加/修改用户" />
                </div>
                <div id="operateContainerrightBlock" >
                    <form action="" method="post" style="position: relative;float: right;margin-left: 10px;">
                        <div>
                            <input id="fileRearch" type="text" style="margin:10px;" />
                            <input id="fileRearch" type="button" style="margin-left: 10px;margin-right: 20px;" value="搜索" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="mainContainer"><!-- 页面调转菜单栏右侧的主要操作区样式 -->
            <div class="userListitem" ><!-- 列表中一个用户元素 -->
                <div id="userListitemBlock">
                    <div style="position: relative; float: left;width: 28px;height: 28px;border: #00ff00 solid 1px;">
                        <input id="cb-0" type="checkbox" style="margin: auto;position: absolute;top: 0;left: 0;bottom: 0;right: 0;margin:5px" /><!---勾选框，调整margin属性可以调整大小---->
                    </div>
                    <div style="position: relative; float: left;width: 28px;height: 28px;border: #00ff00 solid 1px;">
                        <img src="image/icon/user.png" height="25px" width="25px" style="margin: auto;position: absolute;top: 0;left: 0;bottom: 0;right: 0;"><!-- 载入user图片 -->
                    </div>
                    <span style="margin-left: 6px;margin-top: 6px;position: relative;float: left;font-size: 12px;color:#000000">用户名：Admin 一级管理权限</span>
                    <div class="userListitemButtongroup">
                        <input id="Admin" onclick="userListitemClick(this)"  type="button" id="userListitemDel-02" value="用户编辑" />
                        <input type="button" id="userPasswordreset-0" value="重置密码" />
                    </div>
                </div>
            </div>
            <div class="userListitem"><!-- 列表中一个用户元素 -->
                <div id="userListitemBlock">
                    <div style="position: relative; float: left;width: 28px;height: 28px;border: #00ff00 solid 1px;">
                        <input id="cb-1" type="checkbox" style="margin: auto;position: absolute;top: 0;left: 0;bottom: 0;right: 0;margin:5px" /><!---checkbox勾选框，调整margin属性可以调整大小---->
                    </div>
                    <div style="position: relative; float: left;width: 28px;height: 28px;border: #00ff00 solid 1px;">
                        <img src="image/icon/user.png" height="25px" width="25px" style="margin: auto;position: absolute;top: 0;left: 0;bottom: 0;right: 0;"><!-- 载入user图片 -->
                    </div>
                    <span style="margin-left: 6px;margin-top: 6px;position: relative;float: left;font-size: 12px;color:#000000">用户名：sunwuchuan 二级管理权限</span>
                    <div class="userListitemButtongroup">
                        <input id="sunwuchuan" onclick="userListitemClick(this)"  type="button" id="userListitemDel-02" value="用户编辑" />
                        <input type="button" id="userPasswordreset-1" value="重置密码" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script>
    function checkboxIschecked(e){
        //传入全选checkbox
        //作用：判断全选框是否被勾选并勾选用户全选框
        var allCheckboxstate=e.checked;//bool
        var cbNum=2;//checkbox数量，可以通过php方式传递
        if(allCheckboxstate){
            for(var i=0;i<cbNum;i++){
                var cbId="cb-"+i;
                document.getElementById(cbId).checked=true;
            }
        }else{
            for(var i=0;i<cbNum;i++){
                var cbId="cb-"+i;
                document.getElementById(cbId).checked=false;
            }
        }
    }
    function userListitemClick(e){
        //传入单条用户的编辑按钮,按钮id为用户名
        //作用：点击列表中的用户后，字段会被加上上方input框中
        var userNameinput=document.getElementById("userNameinput");//用户名输入框
        userNameinput.value=e.id;
        console.log(e);
    }
    function pageJump(page){
        //传入Page名
        //作用页面跳转
        if (page == ""){
            alert("页面开发中，敬请期待!");
        }else {
            window.location.href=page+".php";
        }
    }
</script>
</html>