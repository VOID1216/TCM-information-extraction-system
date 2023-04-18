<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>中医信息抽取系统</title>
    <link rel="stylesheet" href="CSS/login.css">
    <meta name="content-type" charset="UTF-8">
</head>
<script src="JS/Jquery.js"></script>
<body>
<div id="bigBox">
    <h1>登录页面</h1>
    <form id="login_form" action="action/login_action.php" method="post">
        <div class="inputBox">
            <div class="inputText">
                <label for="id"></label><input type="text" id="id" name="id" placeholder="请输入账号" value="<?php if (isset($_GET['id'])) echo $_GET['id'];?>">
            </div>
            <div class="inputText">
                <label for="password"></label><input type="password" id="password" name="password" placeholder="请输入密码">
            </div>
            <br>
            <div style="color: white;font-size: 12px" >
                <?php
                $err = isset($_GET["err"]) ? $_GET["err"] : "";
                switch ($err) {
                    case 1:
                        echo "用户名或密码错误";
                        break;
                    case 2:
                        echo "用户名或密码不能为空";
                        break;
                } ?>
            </div>
        </div>
        <div>
            <input type="button" id="login" name="login" value="登录" class="loginButton" onclick="doSession()">
        </div>
    </form>
</div>
</body>
<script>
    function doSession(){
        sessionStorage.id = document.getElementById('id').value;
        $('#login_form').submit();
    }
</script>
</html>

