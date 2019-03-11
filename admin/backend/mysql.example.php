<?php
require_once 'config.example.php';
function connect(){  
//连接MySQL  
$conn=@mysqli_connect(HOST,USER,PWD) or die ('数据库连接失败<br/>ERROR'.mysql_errno().':'.mysql_error());  
//字符集    
mysqli_set_charset($conn,CHARSET);  
mysqli_query($conn,"SET NAMES 'utf8'");   
//打开数据库 
mysqli_select_db($conn,DBNAME) or die ('指定的实据库打开失败');  
return $conn;
}

?>
