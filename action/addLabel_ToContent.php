
<?php
require_once '../db_config.php';
session_start();
$textId = $_SESSION['textId'];
header("content-type:text/html; charset=UTF-8");
if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {
    // ajax 请求的处理方式
//    $ifSoloChoose=$_GET['ifSoloChoose'];                        // ifSoloChoose 是否单行选择的标记
    $Array = file_get_contents('php://input');
    $Array = explode(",", $Array);
    $queryString = "select text from assignment where id = '$textId'";
    @$rs = mysqli_query($link, $queryString);
    @$row = mysqli_fetch_row($rs);
    $json = json_decode($row[0], true);

    $countLabel = @count($json['data']['annotation']['labels']);
    $json['data']['annotation']['labels'][$countLabel]['starIndex'] =$Array[0];
    $json['data']['annotation']['labels'][$countLabel]['endIndex'] = $Array[1];
    $json['data']['annotation']['labels'][$countLabel]['id'] = $Array[2];
    $json['data']['annotation']['labels'][$countLabel]['categoryId'] = $Array[3];


    $arr = array_column($json['data']['annotation']['labels'], 'starIndex');
    array_multisort($arr , SORT_ASC, $json['data']['annotation']['labels']);

//    if ($ifSoloChoose=="true"){                        // ifSoloChoose 是否单行选择的标记 跨行选择则会添加标签到头部，反则为添加到尾部，提前渲染跨行的标签;
//
//    }else{
//        $Array_across['starIndex']= $Array[0];
//        $Array_across['endIndex']= $Array[1];
//        $Array_across['id']= $Array[2];
//        $Array_across['categoryId']= $Array[3];
//        if ($json['data']['annotation']['labels']!=[]||in_array("label",$json['data']['annotation'])){
////            echo "已经有label了，可以插值";
//            array_unshift($json['data']['annotation']['labels'],$Array_across);
//        }else{
////            echo "没有label，插首值";
//            $json['data']['annotation']['labels'][0]['starIndex'] =$Array[0];
//            $json['data']['annotation']['labels'][0]['endIndex'] = $Array[1];
//            $json['data']['annotation']['labels'][0]['id'] = $Array[2];
//            $json['data']['annotation']['labels'][0]['categoryId'] = $Array[3];
//        }
//    }

    $json = json_encode($json,JSON_UNESCAPED_UNICODE);

    $queryString = "update assignment set text='$json' where id='$textId'";
    mysqli_query($link, $queryString);
    echo mysqli_error($link);
    echo $json;
}
