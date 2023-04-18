<?php
header("Content-Type: text/html;charset=utf-8");
session_start();
$id = isset($_POST['id']) ? $_POST['id'] : "";
$password = isset($_POST['password']) ? $_POST['password'] : "";
if (!empty($id) && !empty($password)) { //建立连接
    $conn = mysqli_connect('localhost', 'root', '', 'smart_annotation'); //准备SQL语句
    $sql_select = "SELECT id,username,password,level,userGroup FROM user WHERE id = '$id' AND password = '$password'"; //执行SQL语句
    $ret = mysqli_query($conn, $sql_select);
    $row = mysqli_fetch_assoc($ret); //判断用户名或密码是否正确
    var_dump($row);
    $level = $row['level'];//获取权限值
    $userName = $row['username'];
    $_SESSION['userName'] = $userName;
    $_SESSION['group'] = $row['userGroup'];
    if ($id == $row['id'] && $password == $row['password'])
    {
//        $ip = $_SERVER['REMOTE_ADDR'];
//        $date = date('Y-m-d H:m:s');
//        $info = sprintf("当前访问用户：%s,IP地址：%s,时间：%s /n", $username, $ip, $date);
//        $sql_logs = "INSERT INTO logs(username,ip,date) VALUES('$username','$ip','$date')";
//        //日志写入文件，如实现此功能，需要创建文件目录logs
//        $f = fopen('./logs/' . date('Ymd') . '.log', 'a+');
//        fwrite($f, $info);
//        fclose($f); //跳转到loginsucc.php页面
        switch ($level) {
            case "0" :
                header("Location:../file_list.php?name=".$row['username']);//超级管理员
                $_SESSION['level'] = 0;
                break;
            case "1" :
                header("Location:../file_list.php");// 高级管理员
                $_SESSION['level'] = 1;
                break;
            case "2" :
                header("Location:../file_list.php");// 普通管理员
                $_SESSION['level'] = 2;
                break;
        }
    }
    else
    {
        //用户名或密码错误，赋值err为1
        header("Location:../login.php?err=1&id=$id");
    }
} else { //用户名或密码为空，赋值err为2
    header("Location:../login.php?err=2&id=$id");
}
