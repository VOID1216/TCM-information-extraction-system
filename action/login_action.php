<?php
header("Content-Type: text/html;charset=utf-8");
$username = isset($_POST['username']) ? $_POST['username'] : "";
$password = isset($_POST['password']) ? $_POST['password'] : "";
if (!empty($username) && !empty($password)) { //建立连接
    $conn = mysqli_connect('localhost', 'root', '', 'systemTest'); //准备SQL语句
    $sql_select = "SELECT username,password,access FROM user WHERE username = '$username' AND password = '$password'"; //执行SQL语句
    $ret = mysqli_query($conn, $sql_select);
    $row = mysqli_fetch_array($ret); //判断用户名或密码是否正确
    $access = $row['access'];//获取权限值
    if ($username == $row['username'] && $password == $row['password'])
    {
//        $ip = $_SERVER['REMOTE_ADDR'];
//        $date = date('Y-m-d H:m:s');
//        $info = sprintf("当前访问用户：%s,IP地址：%s,时间：%s /n", $username, $ip, $date);
//        $sql_logs = "INSERT INTO logs(username,ip,date) VALUES('$username','$ip','$date')";
//        //日志写入文件，如实现此功能，需要创建文件目录logs
//        $f = fopen('./logs/' . date('Ymd') . '.log', 'a+');
//        fwrite($f, $info);
//        fclose($f); //跳转到loginsucc.php页面
        header("Location:../$access.php"); //关闭数据库,跳转至admin.php
        mysqli_close($conn);
    }
    else
    {
        //用户名或密码错误，赋值err为1
        header("Location:login.php?err=1&username='$username'");
    }
} else { //用户名或密码为空，赋值err为2
    header("Location:login.php?err=2&username=$username");
}
