<?php
require_once("../config.php");

function query($info) {
	$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	
	if ($con->connect_error) {
		return -2;
	}

	$sql = "select name, phone, info from Attendee where name = ? && phone = ?";

	$ret = new StdClass();

	$con->prepare($sql);
	$stmt->bind_param("ss", $info->name, $info->phone);
	$stmt->execute();
	$stmt->bind_result($ret->name, $ret->phone, $ret->info);
	$stmt->fetch();
	$stmt->close();
	$con->close();

	return $ret;
}

function signup($info, $cover) {
	$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	if ($con->connect_error) {
		return -2;
	}

	$q = query($info);

	if (isset($q->name)) {
		if ($cover) {
			$sql1 = "update Attendee set grade = ?, college = ?, dorm = ?, ChoiceOne = ?, ChoiceTwo = ?, adjust = ?, introduction = ? where name = ? && phone = ?";
			$stmt1 = $con->prepare();
			$stmt1->bind_param("sssssssss", $info->grade, $info->college, $info->dorm, $info->ChoiceOne, $info->ChoiceTwo, $info->adjust, $info->introduction, $info->name, $info->phone);
			$stmt1->execute();
			$stmt1->close();
		} else {
			$con->close();
			return -1;
		}
	} else {
		$sql1 = "insert into Attendee (name, phone, grade, college, dorm, ChoiceOne, ChoiceTwo, adjust, introduction) values (?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt1 = $con->prepare();
		$stmt1->bind_param("sssssssss", $info->name, $info->grade, $info->college, $info->dorm, $info->ChoiceOne, $info->ChoiceTwo, $info->adjust, $info->introduction);
		$stmt1->execute();
		$stmt1->close();
	}
	$con->close();

	// TODO: check if success

	return 0;
}

function admin_login($userid, $passwd) {
	/* 还没改不能用 */
	$AllDepart_Name = mysqli_query($conn,"SELECT department FROM `admin`");
	$AllDepart_Name = mysqli_fetch_all($AllDepart_Name, MYSQLI_ASSOC); 

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
}

function admin_query($userid) {
	/* 还没改不能用 */
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
}
