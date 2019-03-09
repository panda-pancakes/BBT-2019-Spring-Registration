<?php
require_once 'config.example.php';
require_once 'mysql.example.php';
$conn=connect();
header('Content-Type: application/json');
error_reporting(E_ALL);                       //报告所有的可能出现的错误，不要抛弃，抛弃的才更应该看！

session_start();
$department = $_SESSION['department'];
if($department !== "南校技术部"){
    $showdata = mysqli_query($conn,"SELECT * FROM `attendee` WHERE `ChoiceOne` = '".$department."'");
    $showdata = mysqli_fetch_all($showdata,MYSQLI_ASSOC);
    $count = count($showdata);                              //计算所有报名人员
    if($count == 0){
        $errmsg = "暂无数据";
        $BoyNum = null;
        $GirlNum = null;
    }else{
    $GirlNum = mysqli_query($conn,"SELECT * FROM `attendee` WHERE `ChoiceOne` = '".$department."' AND `sex` = '女'");
    $GirlNum = mysqli_fetch_all($GirlNum);
    $GirlNum = count($GirlNum);
    $BoyNum = mysqli_query($conn,"SELECT * FROM `attendee` WHERE `ChoiceOne` = '".$department."' AND `sex` = '男'");
    $BoyNum = mysqli_fetch_all($BoyNum);
    $BoyNum = count($BoyNum);
    }
}else{
    $showdata = mysqli_query($conn,"SELECT * FROM `attendee`");
    $showdata = mysqli_fetch_all($showdata,MYSQLI_ASSOC);
    $count = count($showdata);
    if($count == 0){
        $errmsg = "暂无数据";
        $BoyNum = null;
        $GirlNum = null;
    }else{
    $GirlNum = mysqli_query($conn,"SELECT * FROM `attendee` WHERE  `sex` = '女'");
    $GirlNum = mysqli_fetch_all($GirlNum);
    $GirlNum = count($GirlNum);
    $BoyNum = mysqli_query($conn,"SELECT * FROM `attendee` WHERE  `sex` = '男'");
    $BoyNum = mysqli_fetch_all($BoyNum);
    $BoyNum = count($BoyNum);
    }
}
$errmsg = "暂无数据";
$result = [
    "errmsg" => "$errmsg",
    "showdata" => $showdata,
    "sum" => $count,
    "GirlNum" => $GirlNum,
    "BoyNum" => $BoyNum,
];

echo json_encode($result);
