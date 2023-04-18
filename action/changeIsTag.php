<?php
header("content-type:text/html; charset=UTF-8");
if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {
    $textId = $_GET['id'];
    $isTag = $_GET['isTag'];
    if ($isTag == 1){
        $isTag = 0;
    }else{
        $isTag = 1;
    }
    $link = mysqli_connect('localhost','root','','smart_annotation');
    $queryString = "update assignment set isTag=$isTag where id='$textId'";
    mysqli_query($link,$queryString);
}
