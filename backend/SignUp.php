<?php
require_once("connect.php");
//接收姓名
$name = htmlspecialchars($_POST['name'],ENT_QUOTES);
//接收手机号
$phone = htmlspecialchars($_POST['phone'],ENT_QUOTES);
//接收学院
$college = htmlspecialchars($_POST['college'],ENT_QUOTES);
//接收第一志愿
$ChoiceOne = htmlspecialchars($_POST['ChoiceOne'],ENT_QUOTES);
//接收第二志愿
$ChoiceTwo = htmlspecialchars($_POST['ChoiceTwo'],ENT_QUOTES);
//接收是否服从调剂
$adjust = htmlspecialchars($_POST['adjust'],ENT_QUOTES);
//接收个人简介
$introduction = htmlspecialchars($_POST['introduction'],ENT_QUOTES);

$sql = "select name,phone from Attendee where name = ? && phone = ?";
$stmt = mysqli_prepare($con,$sql);
        mysqli_stmt_bind_param($stmt,"ss",$name,$phone);
        mysqli_execute($stmt);
        mysqli_stmt_bind_result($stmt,$FormerName,$FormerPhone);
        mysqli_stmt_fetch($stmt);

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
//检测是否已报名过
else if($name == $FormerName && $phone == $FormerPhone){
    $result = [
        'errcode' => 1,
        'errmsg' => '您已经报名过了哦，是否选择覆盖之前的报名信息',
    ];
    mysqli_stmt_close($stmt);
}
else{
    $sql1 = "insert into Attendee (name, phone, college, ChoiceOne, ChoiceTwo, adjust, introduction) values (?, ?, ?, ?, ?, ?, ?)";
    $stmt1 = mysqli_prepare($con, $sql1);
    mysqli_stmt_bind_param($stmt1, "sssssss", $name, $phone, $college, $ChoiceOne, $ChoiceTwo, $adjust, $introduction);
    mysqli_stmt_execute($stmt1);
    mysqli_stmt_close($stmt1);
    $result = [
        'errcode' => 0,
        'errmsg' => '报名成功！',
    ];
}
?>
