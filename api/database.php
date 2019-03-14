<?php
require_once("../config.php");

function query($info) {
	$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	
	if ($con->connect_error) {
		return -2;
	}

	$sql = "select name, tel, info from attendee where name = ? && tel = ?";

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
			$sql1 = "update attendee set sex = ?, grade = ?, college = ?, dorm = ?, department = ?, alternative = ?, adjustment = ?, introduction = ? where name = ? && tel = ?";
			$stmt1 = $con->prepare();
			$stmt1->bind_param("ssssssssss", $info->sex, $info->grade, $info->college, $info->dorm, $info->department, $info->alternative, $info->adjustment, $info->introduction, $info->name, $info->tel);
			$stmt1->execute();
			$stmt1->close();
		} else {
			$con->close();
			return -1;
		}
	} else {
		$sql1 = "insert into attendee (name, sex, tel, grade, college, dorm, department, alternative, adjustment, introduction) values (?, ?, ?, ?, ?, ?, ?, ?, ?)";
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
	/*3.14 初步按照要求改成合格形式 还没有跑过 不知道会出什么bug (我好困)
	/* 这个文件里只负责数据库的操作 至于怎么处理数据 判断传入的数据合不合法在action.php里做 */
	$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if($conn->connect_error){
		return -2;
	}
	
	$stmt1 = $conn->prepare("select * from applicants where ChoiceOne = ?");
	$stmt1->bind_param("s",$username);
	$stmt2 = $conn->prepare("select * from applicants where ChoiceOne =? and sex = ?");
	$stmt2->bind_param("ss",$username,"女");
	$stmt3 = $conn->prepare("select * from applicants where ChoiceOne =? and sex = ?");
	$stmt3->bind_param("ss",$username,"男");


	if($username !== "南校技术部"){
		$stmt1->execute();
		$showdata = $stmt1->fetch();
		$stmt1->num_rows;
	    if($stmt1 == 0){
	        $errmsg = "暂无数据";
	        $BoyNum = null;
	        $GirlNum = null;
	    }else{
		$stmt2->execute();
		$showdata = $stmt2->fetch();
	    $GirlNum = $stmt2->num_rows;
		$stmt3->execute();
		$showdata = $stmt3->fetch();
		$BoyNum = $stmt3->num_rows;
		$stmt2->close();
		$stmt3->close();
	    }
	}else{
		$stmt4 = $conn->prepare("select * from applicants");
		$stmt4->execute();
		$showdata = $stmt4->fetch();
	    $count = $stmt4->num_rows;
	    if($count == 0){
	        $errmsg = "暂无数据";
	        $BoyNum = null;
	        $GirlNum = null;
	    }else{
		$stmt5 = $conn->prepare("select * from applicants where sex = ?");
		$stmt5->bind_param("s","女");
		$stmt5->execute();
		$showdata = $stmt5->fetch();
		$GirlNum = $stmt5->num_rows;
		$stmt6 = $conn->prepare("select * from applicants where sex = ?");
		$stmt6->bind_param("s","男");
		$stmt6->execute();
		$showdata = $stmt6->fetch();
		$BoyNum = $stmt6->num_rows;
		$stmt5->close();
		$stmt6->close();
	    }
	}

	$result = [
	    "errmsg" => "$errmsg",
	    "showdata" => $showdata,
	    "sum" => $count,
	    "GirlNum" => $GirlNum,
	    "BoyNum" => $BoyNum,
	];


    $conn->close();
	return $result;
}
