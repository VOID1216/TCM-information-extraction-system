<?php
require_once '../db_config.php';
if (isset($_GET)){
    $articleId = $_GET['id'];
    $queryString="delete from assignment  where id='$articleId'";
    mysqli_query($link,$queryString);
    echo mysqli_error($link);
    echo 'success';
}