<meta charset="utf-8">
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2023/3/17
 * Time: 13:31
 */
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2023/1/3
 * Time: 14:06
 */
$link  = mysqli_connect("localhost","root","","");
mysqli_query($link,"set names utf8");
$queryString="create database if not exists smart_annotation";
mysqli_query($link,$queryString);
$queryString="use smart_annotation";
mysqli_query($link,$queryString);//建数据库以及使用
$queryString="create table user(ID VARCHAR(50) PRIMARY KEY,username char(50),password char(50),level enum('0','1','2','3'))ENGINE=MyISAM DEFAULT CHARSET=utf8";
mysqli_query($link,$queryString);

$queryString="create table assignment(id INT PRIMARY KEY,name VARCHAR(50),set_time DATE,text MediumText)ENGINE=MyISAM DEFAULT CHARSET=utf8";
mysqli_query($link,$queryString);


$queryString="insert into user(id,username,password,level)VALUES ('1','Admin','100200','0')"; //user基础插入语句
mysqli_query($link,$queryString);

//$queryString="insert into assignment(id,type,set_time,text)VALUES ('1','数据操作','2020-3-17','文本内容')";  //assignment基础插入语句
//mysqli_query($link,$queryString);

//$queryString="update user set password = XX where id = XX AND password=YY";  //用户修改密码语句
//mysqli_query($link,$queryString);
