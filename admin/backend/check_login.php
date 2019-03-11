<?php
require_once 'config.example.php';
require_once 'mysql.example.php';
$conn=connect();
header('Content-Type: application/json');
error_reporting(E_ALL);                       //报告所有的可能出现的错误，不要抛弃，抛弃的才更应该看！

$department = (string)htmlspecialchars($_POST['department']);
$password = (int)htmlspecialchars($_POST['password']);
password_hash("ilikebbt",PASSWORD_DEFAULT);               //php密码加密

$AllDepart_Name = mysqli_query($conn,"SELECT department FROM `admin`");
$AllDepart_Name = mysqli_fetch_all($AllDepart_Name,MYSQLI_ASSOC);        //所有部门名称--用于遍历

foreach ($AllDepart_Name as $value)
{
   foreach($value as $EachName){
    $result = strcasecmp($EachName,$department);
    if($result == 0){
        $bool = 0;
        break;
    }else{
        $bool = 1;
        continue;
    }
   }
   if($bool == 0){
    break;
   }
}

if($department == null or $password == 0){
    $result=[
        "errcode"=>3,
        "errmsg"=>"输入不能为空",
        "data"=>''
    ];
}elseif($bool == 1){
    $result=[
        "errcode"=>1,
        "errmsg"=>"部门名或密码输入错误",
        "data"=>''
    ];
}elseif($bool == 0){
    $password_check = mysqli_query($conn,"SELECT `password` FROM `admin` where `department`= '".$department."'");
    $password_check = mysqli_fetch_all($password_check);
    if($password_check[0][0] == $password){
        $result=[
            "errcode"=>0,
            "errmsg"=>"登录成功",
            "data"=>''
        ];
        session_start();
        $_SESSION['department'] = $department;
    }else{
        $result=[
            "errcode"=>2,
            "errmsg"=>"部门名或密码输入错误",
            "data"=>''
        ];
    }
}

echo json_encode($result);


