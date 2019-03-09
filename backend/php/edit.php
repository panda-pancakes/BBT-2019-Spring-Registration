<?php
require_once("connect.php");
//获取要修改信息的用户原信息
Session_start();
$FormerName = $_SESSION['name'];
$FormerPhone = $_SESSION['phone'];

//接收姓名
$name = htmlspecialchars($_POST['name'],ENT_QUOTES);
//接收手机号
$phone = htmlspecialchars($_POST['phone'],ENT_QUOTES);
//接收年级
$grade = htmlspecialchars($_POST['grade'],ENT_QUOTES);
//接收学院
$college = htmlspecialchars($_POST['college'],ENT_QUOTES);
//接收宿舍
$dorm = htmlspecialchars($_POST['dorm'],ENT_QUOTES);
//接收第一志愿
$ChoiceOne = htmlspecialchars($_POST['ChoiceOne'],ENT_QUOTES);
//接收第二志愿
$ChoiceTwo = htmlspecialchars($_POST['ChoiceTwo'],ENT_QUOTES);
//接收是否服从调剂
$adjust = htmlspecialchars($_POST['adjust'],ENT_QUOTES);
//接收个人简介
$introduction = htmlspecialchars($_POST['introduction'],ENT_QUOTES);

//手机号长度和数字判断
$NumPhone = strlen($phone);
$IsNum = is_numeric($phone)?true:false;

//个人介绍长度
$IntroLength = mb_strlen($introduction);

//检测手机号是否符合条件：数字,1开头，11位
if($IsNum == false || $phone[0] != 1 || $NumPhone != 11){
    $result = [
        'errcode' => 1,
        'errmsg' => '请填写正确的手机号码',
    ];
}
//检测个人简介是否超过50字
else if($IntroLength >=50){
    $result = [
        'errcode' => 1,
        'errmsg' => '个人简介不可超过50字哦',
    ];
}
else{
    $sql = "update Attendee set name = ?, phone = ?, grade = ?, college = ?, dorm = ?, ChoiceOne = ?, ChoiceTwo = ?, adjust = ?, introduction = ? where name = ? && phone = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "sssssssssss", $name, $phone, $grade, $college, $dorm, $ChoiceOne, $ChoiceTwo, $adjust, $introduction, $FormerName, $FormerPhone);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $result = [
        'errcode' => 0,
        'errmsg' => '修改成功！',
    ];
}
echo json_encode($result);
?>