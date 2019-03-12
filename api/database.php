<?php
require_once("../config.php");

function query($info) {
	$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	
	if ($con->connect_error) {
		return -2;
	}

	$sql = "select name, tel, info from Attendee where name = ? && tel = ?";

	$ret = new StdClass();

	$con->prepare($sql);
	$stmt->bind_param("ss", $info->name, $info->tel);
	$stmt->execute();
	$stmt->bind_result($ret->name, $ret->tel, $ret->info);
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

	if (isset($q->name) && isset($q->tel)) {
		if ($cover) {
			$sql1 = "update Attendee set sex = ?, grade = ?, college = ?, dorm = ?, department = ?, alternative = ?, adjustment = ?, introduction = ? where name = ? && tel = ?";
			$stmt1 = $con->prepare();
			$stmt1->bind_param("ssssssssss", $info->sex, $info->grade, $info->college, $info->dorm, $info->department, $info->alternative, $info->adjustment, $info->introduction, $info->name, $info->tel);
			$stmt1->execute();
			$stmt1->close();
		} else {
			$con->close();
			return -1;
		}
	} else {
		$sql1 = "insert into Attendee (name, sex, tel, grade, college, dorm, department, alternative, adjustment, introduction) values (?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt1 = $con->prepare();
		$stmt1->bind_param("ssssssssss", $info->name, $info->sex, $info->tel, $info->grade, $info->college, $info->dorm, $info->department, $info->alternative, $info->adjustment, $info->introduction);
		$stmt1->execute();
		$stmt1->close();
	}
	$con->close();

	// TODO: check if success

	return 0;
}

function admin_login($username, $passwd) {
	$enc_pwd = md5($passwd);
	$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	if ($con->connect_error) {
		return -2;
	}

	$stmt = $con->prepare("select * from user_info where username=? and password=?");
	$stmt->bind_param("ss", $username, $enc_pwd);

	if ($stmt->execute()) {
		if (!$stmt->fetch()) {
			return -3;
		}
	}

	$stmt->close();
	$con->close();

	/* To-do: 返回值改成permission */

	return 0;
}

function admin_query($username) {
	/* 还没改不能用 */
	/* 这个文件里只负责数据库的操作 至于怎么处理数据 判断传入的数据合不合法在action.php里做 */

	if($username !== "南校技术部"){
	    $showdata = mysqli_query($conn,"SELECT * FROM `attendee` WHERE `ChoiceOne` = '".$username."'");
	    $showdata = mysqli_fetch_all($showdata,MYSQLI_ASSOC);
	    $count = count($showdata);                              //计算所有报名人员
	    if($count == 0){
	        $errmsg = "暂无数据";
	        $BoyNum = null;
	        $GirlNum = null;
	    }else{
	    $GirlNum = mysqli_query($conn,"SELECT * FROM `attendee` WHERE `ChoiceOne` = '".$username."' AND `sex` = '女'");
	    $GirlNum = mysqli_fetch_all($GirlNum);
	    $GirlNum = count($GirlNum);
	    $BoyNum = mysqli_query($conn,"SELECT * FROM `attendee` WHERE `ChoiceOne` = '".$username."' AND `sex` = '男'");
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
