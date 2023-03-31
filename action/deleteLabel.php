<?php
header("content-type:text/html; charset=UTF-8");
if (isset($_POST)) {
    $id = $_GET['id'];
//    $id = 3;
    $jsonString = file_get_contents('php://input');
//    $jsonString = '{"data":{"id":1,"annotation":{"content":"1.首先创建form表单，设置input的type为file实现文件的上传，代码如下：1.首先创建form表单，设置input的type为file实现文件的上传，代码如下：2.然后写php脚本去实现上传文件的功能，代码如下：1.首先创建form表单，设置input的type为file实现文件的上传，代码如下：1.首先创建form表单，设置input的type为file实现文件的上传，代码如下：2.然后写php脚本去实现上传文件的功能，代码如下：1.首先创建form表单，设置input的type为file实现文件的上传，代码如下：2.然后写php脚本去实现上传文件的功能，代码如下：1.首先创建form表单，设置input的type为file实现文件的上传，代码如下：2.然后写php脚本去实现上传文件的功能，代码如下：————————————————版权声明：本文为CSDN博主「柒℡.」的原创文章，遵循CC 4.0 BY-SA版权协议，转载请附上原文出处链接及本声明。原文链接：https://blog.csdn.net/weixin_47665578/article/details/124145222","labelCategories":{"0":{"id":1,"text":"123","color":"#66ccff","borderColor":"#999999"},"2":{"id":3,"text":"123","color":"#66ff84","borderColor":"#999999"}}}}}';
    $json = json_decode($jsonString, true);
//    echo json_last_error();
//    var_dump($json['data']['annotation']['labelCategories']);
    foreach ($json['data']['annotation']['labelCategories'] as $val) {
        if ($val['id'] == $id) {
            unset($json['data']['annotation']['labelCategories'][$val['id']-1]);
            break;
        }
    }
    echo '<br>';
//    var_dump($json['data']['annotation']['labelCategories']);
    $textId = $json['data']['id'];
    $jsonText = json_encode($json,JSON_UNESCAPED_UNICODE);
    $link = mysqli_connect('localhost','root','','smart_annotation');
    $queryString="update assignment set text='$jsonText' where id='$textId'";
    mysqli_query($link,$queryString);
    echo '成功！';
//    echo mysqli_error($link);
//    $queryString="select text from assignment where id='$textId'";
//    $row=mysqli_fetch_row(mysqli_query($link,$queryString));
//    echo $row[0];
    //$json = json_decode($json, true);
    //var_dump($json);
}