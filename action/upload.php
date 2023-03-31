<?php
header("content-type:text/html; charset=UTF-8");
if(isset($_POST["btnUpload"])) {
    if ($_FILES["myFile"]["type"] == 'text/plain') {
        $fileName = $_FILES["myFile"]["name"];
//        $fileName=iconv('UTF-8','GBK',$fileName);
        move_uploaded_file($_FILES["myFile"]["tmp_name"],"../file/".$fileName);
//        $fileName='肝郁气滞.txt';
//        $fileName=iconv("UTF-8",'GBK',$fileName);
        $content=file_get_contents("../file/".$fileName);//读取txt文件
//        $content=iconv("GBK","UTF-8",$content);
//        echo $content;
        $link=mysqli_connect("localhost","root","","smart_annotation");
        $queryString="select max(id) as maxId FROM assignment";
        $rs=mysqli_query($link,$queryString);
        $row=mysqli_fetch_assoc($rs);
        if ($row['maxId']==NULL){
            $countId=1;
        }else{
            $countId=$row['maxId']+1;
        }
        $json=array('data'=>array('id'=>$countId,'annotation'=>array('content'=>$content)));
//        var_dump($json);
        $s=json_encode($json,JSON_UNESCAPED_UNICODE);
        $date=getdate()['year'].'-'.getdate()['mon'].'-'.getdate()['mday'];
        $queryString="insert into assignment(id,name,set_time,text)VALUES('$countId','$fileName','$date','$s')";
        mysqli_query($link,$queryString);
        echo mysqli_error($link);
    }
}