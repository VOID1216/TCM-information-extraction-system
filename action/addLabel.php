<?php
header("content-type:text/html; charset=UTF-8");
require_once '../db_config.php';
if (isset($_POST)){
    $jsonString = file_get_contents('php://input');
    echo $jsonString;
    $json=json_decode($jsonString,true);
    $id=$json['data']['id'];
    $queryString="update assignment set text='$jsonString' where id='$id'";
    mysqli_query($link,$queryString);
//    echo mysqli_error($link);
    //$json = json_decode($json, true);
    //var_dump($json);
}