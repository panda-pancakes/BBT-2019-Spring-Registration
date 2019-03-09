<?php
require_once("connect.php");
Session_start();
//接收姓名
$name = htmlspecialchars($_SESSION['name'],ENT_QUOTES);
//接收手机号
$phone = htmlspecialchars($_SESSION['phone'],ENT_QUOTES);
//接收年级
$grade = htmlspecialchars($_SESSION['grade'],ENT_QUOTES);
//接收学院
$college = htmlspecialchars($_SESSION['college'],ENT_QUOTES);
//接收宿舍
$dorm = htmlspecialchars($_SESSION['dorm'],ENT_QUOTES);
//接收第一志愿
$ChoiceOne = htmlspecialchars($_SESSION['ChoiceOne'],ENT_QUOTES);
//接收第二志愿
$ChoiceTwo = htmlspecialchars($_SESSION['ChoiceTwo'],ENT_QUOTES);
//接收是否服从调剂
$adjust = htmlspecialchars($_SESSION['adjust'],ENT_QUOTES);
//接收个人简介
$introduction = htmlspecialchars($_SESSION['introduction'],ENT_QUOTES);

$sql = "update Attendee set grade = ?, college = ?, dorm = ?, ChoiceOne = ?, ChoiceTwo = ?, adjust = ?, introduction = ? where name = ? && phone = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "sssssssss", $grade, $college, $dorm, $ChoiceOne, $ChoiceTwo, $adjust, $introduction, $name, $phone);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $result = [
        'errcode' => 0,
        'errmsg' => '覆盖成功！',
    ];
echo json_encode($result);
?>