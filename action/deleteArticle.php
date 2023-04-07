<?php
if (isset($_GET)){
    $articleId = $_GET['id'];
    $link = mysqli_connect('localhost','root','','smart_annotation');
    $queryString="delete from assignment  where id='$articleId'";
    mysqli_query($link,$queryString);
    echo mysqli_error($link);
    echo 'success';
}