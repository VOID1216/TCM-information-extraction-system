<?php
if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {
    $id = $_GET['id'];
//    $id = 3;
    $count=0;
    $labelId = file_get_contents('php://input');
//    $labelId = '2_php_3';
    $link = mysqli_connect('localhost','root','','smart_annotation');
    $queryString = "select text from assignment where id='$id'";
    $row = mysqli_fetch_row(mysqli_query($link,$queryString));
//    echo $row[0];
    $json = json_decode($row[0],true);
//    foreach ($json['data']['annotation']['labels'] as $val) {
//        if ($val['id'] == $labelId) {
//            unset($json['data']['annotation']['labels'][$count]);
//            break;
//        }
//        $count++;
//    }
    for ($i = 0; $i < count($json['data']['annotation']['labels']); ++$i){
        if ($json['data']['annotation']['labels'][$i]['id'] == $labelId) {
            unset($json['data']['annotation']['labels'][$i]);
            break;
        }
    }
    $jsonText = json_encode($json,JSON_UNESCAPED_UNICODE);
    $link = mysqli_connect('localhost','root','','smart_annotation');
    $queryString="update assignment set text='$jsonText' where id='$id'";
    mysqli_query($link,$queryString);
    echo $jsonText;
}