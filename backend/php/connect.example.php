<?php
header('Content-Type: application/json');
$con = mysqli_connect("localhost","root","password","registration");
if (!$con){
    $result = [
        'errcode' => 1,
        'errmsg' => '数据库连接失败',
        'data' => ''
           ]; 
           echo json_encode($result);
           exit();
}
?>