<?php
require_once("connect.php");
Session_start();
//接收姓名
$name = htmlspecialchars($_POST['name'],ENT_QUOTES);
//接收手机号
$phone = htmlspecialchars($_POST['phone'],ENT_QUOTES);
//获取已有信息
$sql = "select grade, college, dorm, ChoiceOne, ChoiceTwo, adjust, introduction from Attendee where name = ? && phone = ?";
$stmt = mysqli_prepare($con,$sql);
        mysqli_stmt_bind_param($stmt,"ss",$name,$phone);
        mysqli_execute($stmt);
        mysqli_stmt_bind_result($stmt,$grade, $college, $dorm, $ChoiceOne, $ChoiceTwo, $adjust, $introduction);
        mysqli_stmt_fetch($stmt);

//判断是否有此人的报名信息（用一个必填选项判断是否为空）
if(empty($grade)){
    $result = [
        'errcode' => 1,
        'errmsg' => '无报名信息，请检查信息是否填写正确',
            ]; 
}
else{
    $result = [
            'errcode' => 0,
            'errmsg' => '查询成功',
            'grade' => $grade,
            'college' => $college,
            'dorm' => $dorm,
            'ChoiceOne' => $ChoiceOne,
            'ChoiceTwo' => $ChoiceTwo,
            'adjust' => $adjust,
            'introduction' => $introduction,
                ]; 
}        
echo json_encode($result);
mysqli_stmt_close($stmt);
?>