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
$queryString="create database smart_annotation DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
mysqli_query($link,$queryString);
$link  = mysqli_connect("localhost","root","","smart_annotation");
mysqli_query($link,"set names 'utf8'");
$queryString="create table user(id VARCHAR(50) PRIMARY KEY,username char(50),password char(50),level enum('0','1','2'),userGroup VARCHAR(50))ENGINE=MyISAM DEFAULT CHARSET=utf8";
mysqli_query($link,$queryString);
echo mysqli_error($link);

$queryString="create table assignment(id INT PRIMARY KEY,name VARCHAR(50),set_time DATE,text MediumText,class VARCHAR(50),isTag boolean,isPublic boolean,articleGroup VARCHAR(50),check1 boolean,check2 boolean)ENGINE=MyISAM DEFAULT CHARSET=utf8";
mysqli_query($link,$queryString);
echo mysqli_error($link);

$queryString="insert into user(id,username,password,level,userGroup) VALUES ('10000','user0','100200','0','0')"; //user基础插入语句
mysqli_query($link,$queryString);
$queryString="insert into user(id,username,password,level,userGroup) VALUES ('10001','user1','100200','2','1-1')"; //user基础插入语句
mysqli_query($link,$queryString);
$queryString="insert into user(id,username,password,level,userGroup) VALUES ('10002','user2','100200','2','1-2')"; //user基础插入语句
mysqli_query($link,$queryString);
$queryString="insert into user(id,username,password,level,userGroup) VALUES ('10003','user3','100200','2','1-3')"; //user基础插入语句
mysqli_query($link,$queryString);
$queryString="insert into user(id,username,password,level,userGroup) VALUES ('10004','user4','100200','2','2-1')"; //user基础插入语句
mysqli_query($link,$queryString);
$queryString="insert into user(id,username,password,level,userGroup) VALUES ('10005','user5','100200','2','2-2')"; //user基础插入语句
mysqli_query($link,$queryString);
$queryString="insert into user(id,username,password,level,userGroup) VALUES ('10006','user6','100200','2','2-3')"; //user基础插入语句
mysqli_query($link,$queryString);
$queryString="insert into user(id,username,password,level,userGroup) VALUES ('10007','user7','100200','2','3-1')"; //user基础插入语句
mysqli_query($link,$queryString);
$queryString="insert into user(id,username,password,level,userGroup) VALUES ('10008','user8','100200','2','3-2')"; //user基础插入语句
mysqli_query($link,$queryString);
$queryString="insert into user(id,username,password,level,userGroup) VALUES ('10009','user9','100200','2','3-3')"; //user基础插入语句
mysqli_query($link,$queryString);
$queryString="insert into user(id,username,password,level,userGroup) VALUES ('10010','user10','100200','2','4-1')"; //user基础插入语句
mysqli_query($link,$queryString);
$queryString="insert into user(id,username,password,level,userGroup) VALUES ('10011','user11','100200','2','4-2')"; //user基础插入语句
mysqli_query($link,$queryString);
$queryString="insert into user(id,username,password,level,userGroup) VALUES ('10012','user12','100200','2','4-3')"; //user基础插入语句
mysqli_query($link,$queryString);
$queryString="insert into user(id,username,password,level,userGroup) VALUES ('10013','user13','100200','2','4-4')"; //user基础插入语句
mysqli_query($link,$queryString);

//$queryString="insert into assignment(id,type,set_time,text)VALUES ('1','数据操作','2020-3-17','文本内容')";  //assignment基础插入语句
//mysqli_query($link,$queryString);

//$queryString="update user set password = XX where id = XX AND password=YY";  //用户修改密码语句
//mysqli_query($link,$queryString);
