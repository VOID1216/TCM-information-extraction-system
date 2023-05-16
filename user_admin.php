<?php
require_once "db_config.php";
session_start();
$userName = $_SESSION['userName'];
$userTablename = "user";
$userNum = getCurrentPageUserListNum($link, $userTablename, "");
function getCurrentPageUserListNum($link, $Table, $addString)
{
    //获取当前表中数量,$addString中第一个字符必须是空格
    $rs = mysqli_query($link, "select count(*) as num from $Table $addString");
    $row = mysqli_fetch_assoc($rs);
    return $row["num"];
}

if (isset($_POST["fileResearchButton"])) {
    //搜索按钮功能
    $fileResearchInput = $_POST["fileResearchInput"];
    if ($fileResearchInput == "") {
        $extraCondition = "";
    } else {
        $extraCondition = " where username like '$fileResearchInput%' ";
    }
    $userNum = getCurrentPageUserListNum($link, $userTablename, $extraCondition);//重新计算当前页面用户数
} else {
    $extraCondition = "";
    $fileResearchInput = "";
}
if (isset($_POST["userlist"])) {
    //删除按钮
    $userDelListArray = $_POST["userlist"];
    for ($i = 0; $i < count($userDelListArray); $i++) {
        mysqli_query($link, "delete from $userTablename where username='$userDelListArray[$i]'");
        //未加入权限判断（例如管理等级低的不能删除等级高的，或者只有管理员能删）
    }
    $userNum = getCurrentPageUserListNum($link, $userTablename, $extraCondition);//重新计算当前页面用户数
}
if (isset($_POST["userAddandEditbutton"])) {
    //添加/修改按钮 没有判断是否为空！！！！！
    $userName = $_POST["userNameinput"];
    $userPassword = $_POST["userPasswordinput"];
    $level = $_POST["userLevelselect"];
    $tempPassword = md5($userPassword);
    if ($level == "1" || $level == "2" || $level == "3") {
        //条件判断防止修改html操作添加数据
        $rs = mysqli_query($link, "select count(*) as num from $userTablename where username='$userName'");
        $row = mysqli_fetch_assoc($rs);
        if ($row["num"] == "0") {
            //新增用户
            $row["num"] = "999";
            while ($row["num"] != "0") {
                $newId = rand(1, 99999999999);
                $rs = mysqli_query($link, "select count(ID) as num from $userTablename where ID='$newId'");
                $row = mysqli_fetch_assoc($rs);
            }//获取未使用过的id
            $queryString = "insert into $userTablename(ID,username,password,level) values('$newId','$userName','$tempPassword','$level')";
            mysqli_query($link, $queryString);
            $userNum++;
        } else {
            //修改用户
            $queryString = "update user set password='$tempPassword',level='$level' where username='$userName'";
            mysqli_query($link, $queryString);
        }
    }
} else {
    $userName = "";
    $userPassword = "";
    $level = 1;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>信息抽取平台</title>
</head>
<link rel="stylesheet" type="text/css" href="CSS/user_admin.css"/>
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
            <div id="userName" style="text-align: center;margin-top: 0 ; position: absolute; top:10px;left:50px;"></div>
        </div><!-- 网页最上方TOP右侧用户位置 -->
    </div>
    <div id="leftMenu" class="leftMenu" style="width: 150px;"><!-- 网页左侧Left跳转功能栏 -->
        <ul class="leftMenulist">
            <li onclick="pageJump('file_list')"><span
                    style="display: block; text-align: center; line-height: 30px; color: black;">文章列表</span></li>
            <!-- 按钮内容 -->
            <li onclick="pageJump('user_admin')"><span
                    style="display: block; text-align: center; line-height: 30px; color: black;">用户管理</span></li>
            <li onclick="pageJump('')"><span
                    style="display: block; text-align: center; line-height: 30px; color: black;">日志</span></li>
            <li onclick="pageJump('')"><span
                    style="display: block; text-align: center; line-height: 30px; color: black;">数据备份站</span></li>
        </ul>
    </div>
    <div>
        <!-- 主要操作区上方的长条操作板块样式 -->
        <div class="operateContainer" id="operateContainerallBlock">
            <div style="width: 166px">
                <div style="position:absolute; float: left;width: 28px;height: 28px;border: 3px double rgb(201, 191, 181);margin-top: 6px;margin-bottom: 6px;">
                <input id="ck-all" type="checkbox"
                       style="margin: auto;position: absolute;top: 0;left: 0;bottom: 0;right: 0;margin:2px"
                       onclick="checkboxIschecked(this)"/>
                 </div>
                <label style="margin-left: 40px">全选</label>
                <input onclick="formSubmit('userListForm')" id="userDelbutton" name="userDelbutton" type="button"
                   value="删除用户" style="margin: 10px;"/>
            </div>

            <div style="position: absolute ;left: 300px;top: 0px;width: 730px">
                <form action="" method="post" style="margin: 10px;">
                    用户名<input id="userNameinput" name="userNameinput" type="text" placeholder="请输入要创建用户名称" value="<?php echo $userName; ?>"/>
                    密码<input id="userPasswordinput" name="userPasswordinput" type="text" placeholder="请输入用户密码" value="<?php echo $userPassword; ?>"/>
                    权限<select id="userLevelselect" name="userLevelselect">
                        <option value="1">1级管理权限</option>
                        <option value="2">2级管理权限</option>
                        <option value="3">3级管理权限</option>
                    </select>
                    <input id="userAddandEditbutton" name="userAddandEditbutton" type="submit"
                           style="margin-left: 10px;margin-right: 20px;" value="添加/修改用户"/>
                </form>
            </div>
<!--            ;left: 900px;top: 8px"-->
            <div style="position: absolute;left: 1030px;top: 0px">
                <form action="" method="post" style="position: relative;float: right;margin: 10px;">
                    <div>
                        <input id="fileRearchInput" name="fileResearchInput" type="text" placeholder="请输入查询用户名称" value="<?php echo $fileResearchInput; ?>"/>
                        <input id="fileRearchButton" name="fileResearchButton" type="submit" value="搜索"/>
                    </div>
                </form>
            </div>

        </div>
        <div class="mainContainer"><!-- 页面调转菜单栏右侧的主要操作区样式 -->
            <form id="userListForm" action="" method="post">
                <?php
                if ($extraCondition != "") {
                    echo "<input type='submit' name='research' value='返回' style='background:#ffffff;'/>";
                    //未完善！！！(清空条件)
                }
                $rs = mysqli_query($link, "select * from $userTablename $extraCondition");
                $i = 0;
                while ($row = mysqli_fetch_assoc($rs)) {
                    echo "<div class='userListitem' ><!-- 列表中一个用户元素 -->";
                    echo "  <div id='userListitemBlock'>";
                    echo "      <div style='position: relative; float: left;width: 28px;height: 28px;	border: 3px double rgb(201, 191, 181);'>";
                    echo "          <input id='cb$i' name='userlist[]' value='$row[username]' type='checkbox' style='margin: auto;position: absolute;top: 0;left: 0;bottom: 0;right: 0;margin:5px' />";
                    echo "      </div>";
                    echo "      <div style='position: relative; float: left; width: 28px;height: 28px;'>";
                    echo "          <img src='image/icon/user.png' height='25px' width='25px' style='margin-top:5px; position: absolute;top: 0;left: 5px;bottom: 0;right: 0;'>";
                    echo "      </div>";
                    echo "      <span style='margin-left: 6px;margin-top: 10px;position: relative;float: left;font-size: 12px;color:#000000'>用户名：$row[username] $row[level]级管理权限</span>";
                    echo "      <div class='userListitemButtongroup'>";
                    echo "          <input id='$row[username]_$row[level]' onclick='userListitemClick(this)' type='button' id='userListitemDel-02' value='用户编辑' />";
                    echo "          <input type='button' style='margin-left: 20px' id='userPasswordreset-0' value='重置密码' />";
                    echo "      </div>";
                    echo "  </div>";
                    echo "</div>";
                    $i++;//input的Id编码
                }
                ?>
            </form>
        </div>
    </div>
</div>
</body>
<script>
    console.log('<?php echo $userName?>');
    if (sessionStorage.id === undefined) {
        window.location.href = 'login.php';
    } else {
        $('#userName').html('<?php echo $userName?>');
    }

    function checkboxIschecked(e) {
        //传入全选checkbox
        //作用：判断全选框是否被勾选并勾选用户全选框
        var allCheckboxstate = e.checked;//bool
        var cbNum =<?php echo $userNum; ?>;//checkbox数量，可以通过php方式传递
        if (allCheckboxstate) {
            for (var i = 0; i < cbNum; i++) {
                var cbId = "cb" + i;
                document.getElementById(cbId).checked = true;
            }
        } else {
            for (var i = 0; i < cbNum; i++) {
                var cbId = "cb" + i;
                document.getElementById(cbId).checked = false;
            }
        }
    }

    function userListitemClick(e) {
        //传入单条用户的编辑按钮,按钮id为用户名_权限等级
        //作用：点击列表中的用户后，字段会被加上上方input框中,select框会读取其权限等级
        var userNameinput = document.getElementById("userNameinput");//用户名输入框
        var userLevelselect = document.getElementById("userLevelselect");//用户名输入框
        userNameinput.value = e.id.split("_")[0];
        userLevelselect.options[e.id.split("_")[1] - 1].selected = true;
    }

    function pageJump(page) {
        //传入Page名
        //作用页面跳转
        if (page === "") {
            alert("页面开发中，敬请期待!");
        } else {
            window.location.href = page + ".php";
        }
    }

    function formSubmit(form) {
        //传入Page名
        //调用方法提交form
        document.getElementById(form).submit();
    }

    function userAddAndEditButtonValueChange() {
        //当用户名输入改变的时候userAddandEditbutton修改删除按钮中的value改变
        //待开发！！！
    }
</script>
</html>