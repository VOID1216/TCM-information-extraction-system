<?php
header("content-type:text/html; charset=UTF-8");
$recordClass = "";
$isPublic = 'false';
if (isset($_FILES['uploadFile'])){
    $recordClass = $_POST['recordClass'];
    $isPublic = $_POST['isPublic'];
    if ($isPublic == 'true')
        $isPublic = 1;
    else
        $isPublic = 0;
//    echo $isPublic;
    $group = $_POST['group'];
    $link = mysqli_connect("localhost", "root", "", "smart_annotation");
    $queryString = "select count(id) as counter FROM assignment where class='$recordClass'";
    $rs = mysqli_query($link, $queryString);
    $row = mysqli_fetch_assoc($rs);
    $nameCounter = 0;
    $nameCounter = $row['counter'];
    for($i = 0; $i < count($_FILES['uploadFile']['name']); ++$i){
        if ($_FILES["uploadFile"]["type"][$i] == 'text/plain') {
            $fileName = $_FILES["uploadFile"]["name"][$i];
            $nameCounter++;

            $fileName = $recordClass."医案".$nameCounter;

            $fileName = iconv("UTF-8", 'GBK', $fileName);
//            echo $_FILES["uploadFile"]["tmp_name"][$i];
            move_uploaded_file($_FILES["uploadFile"]["tmp_name"][$i], "file/" . $fileName);
            $content = file_get_contents("file/" . $fileName);
            $charset[1] = substr($content, 0, 1);
            $charset[2] = substr($content, 1, 1);
            $charset[3] = substr($content, 2, 1);
            $auto = 1;
            if(ord($charset[1]) == 239 && ord($charset[2]) == 187 && ord($charset[3]) == 191){
                $content = substr($content, 3);
                echo 'BOM found';
            }
            else echo 'BOM not found';
            $fileName = iconv("GBK", 'UTF-8', $fileName);
            $content = str_replace("\n", '￥', $content);
            $content = str_replace("\r", '￥', $content);
            $content = str_replace("\t", '', $content);
            $content = str_replace('"', '”', $content);
            $content = str_replace(' ', '', $content);
            $content = str_replace("'", "’", $content);
//            echo $content;
            $queryString = "select max(id) as maxId FROM assignment";
            $rs = mysqli_query($link, $queryString);
            $row = mysqli_fetch_assoc($rs);
            if ($row['maxId'] == NULL) {
                $countId = 1;
            } else {
                $countId = $row['maxId'] + 1;
            }
            $json=array('data'=>array('id'=>$countId,'annotation'=>array('content'=>$content,'labelCategories'=>array(
                array('id'=>1,'text'=>'症状','color'=>'#20b4fe','borderColor'=>'#999999'),
                array('id'=>2,'text'=>'舌像','color'=>'#ff6666','borderColor'=>'#999999'),
                array('id'=>3,'text'=>'脉象','color'=>'#e1c747','borderColor'=>'#999999'),
                array('id'=>4,'text'=>'病位证素','color'=>'#66ffe6','borderColor'=>'#999999'),
                array('id'=>5,'text'=>'病性证素','color'=>'#c966ff','borderColor'=>'#999999')
            ))));
//        var_dump($json);
            $s = json_encode($json, JSON_UNESCAPED_UNICODE);
//            echo $s;
            $date = getdate()['year'] . '-' . getdate()['mon'] . '-' . getdate()['mday'];
            $queryString = "insert into assignment(id,name,set_time,text,class,isTag,isPublic,articleGroup,check1,check2)VALUES('$countId','$fileName','$date','$s','$recordClass',false,$isPublic,'$group',0,0)";
//            echo $queryString;
            mysqli_query($link, $queryString);
            echo mysqli_error($link);
//            echo 'success';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>中医信息抽取系统</title>
    <meta name="content-type" charset="UTF-8">
</head>
<script src="JS/Jquery.js"></script>
<body>
<form id="uploadForm" action="" method="post" enctype="multipart/form-data">
    <label for="recordClass">医案类型：</label><input type="text" id="recordClass" name="recordClass" value="<?php echo $recordClass;?>"><br>
    <label for="group">小组：</label><input type="text" id="group" name="group" value="4-"><br>
    是否小组公开：<label for="public">公开</label><input type="radio" id="public" name="isPublic" value='true' >
    <label for="private">私密</label><input type="radio" id="private" name="isPublic" value='false' checked><br>
    选择文件：<input type="file" id="uploadFile" name="uploadFile[]" multiple="multiple"><br>
    <input type="submit" id="ok" name="ok" value="上传">
</form>
</body>
