<?php
require_once("connect.php");

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
if (isset($_POST['ChoiceTwo'])){
    $ChoiceTwo = htmlspecialchars($_POST['ChoiceTwo'],ENT_QUOTES);
}
else{
    $ChoiceTwo = 'null';
}
//接收是否服从调剂
$adjust = htmlspecialchars($_POST['adjust'],ENT_QUOTES);
//接收个人简介
if (isset($_POST['introduction'])){
    $introduction = htmlspecialchars($_POST['introduction'],ENT_QUOTES);
}
else{
    $introduction = 'null';
}

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