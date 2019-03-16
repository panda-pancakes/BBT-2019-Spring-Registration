<?php
require_once("../config.php");

function query($info) {
	$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	
	if ($con->connect_error) {
		return -2;
	}

	$sql = "select name, sex, tel, grade, college, dorm, department, alternative, adjustment, introduction, information from application where name = ? && tel = ?";

	$ret = new StdClass();

	$stmt = $con->prepare($sql);
	$stmt->bind_param("ss", $info["name"], $info["tel"]);
	$stmt->execute();
	$stmt->bind_result($ret->name, $ret->sex, $ret->tel, $ret->grade, $ret->college, $ret->dorm, $ret->department, $ret->alternative, $ret->adjustment, $ret->introduction, $ret->information);
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
			$sql1 = "update application set sex = ?, grade = ?, college = ?, dorm = ?, department = ?, alternative = ?, adjustment = ?, introduction = ? where name = ? && tel = ?";
			$stmt1 = $con->prepare();
			$stmt1->bind_param("ssssssssss", $info->sex, $info->grade, $info->college, $info->dorm, $info->department, $info->alternative, $info->adjustment, $info->introduction, $info->name, $info->tel);
			$stmt1->execute();
			$stmt1->close();
		} else {
			$con->close();
			return -1;
		}
	} else {
		$sql1 = "insert into application (name, sex, tel, grade, college, dorm, department, alternative, adjustment, introduction) values (?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt1 = $con->prepare($sql1);
		$stmt1->bind_param("ssssssssss", $info->name, $info->sex, $info->tel, $info->grade, $info->college, $info->dorm, $info->department, $info->alternative, $info->adjustment, $info->introduction);
		$stmt1->execute();
		$stmt1->close();
	}
	$con->close();

	// TODO: check if success

	return 0;
}

function admin_login($username, $passwd) {	
	$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	if ($con->connect_error) {
		return -2;

	} else {
		$enc_pwd = md5($passwd);
		$stmt = $con->prepare("select permission from admin where department=? and password=?");
		$stmt->bind_param("ss", $username, $enc_pwd);
		$stmt->execute();
		$stmt->bind_result($ret);
		$stmt->fetch();
		$stmt->close();
		$con->close();

		return $ret;
	}
}


function admin_query($permission) {

	$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	if($con->connect_error){
		return -2;

	} else {	
		if ($permission === 0) {
			$stmt = $con->prepare("select * from application");
		} else {
			$stmt = $con->prepare("select * from application where department = ?");
			$stmt->bind_param("s", $permission);
		}
		$stmt->execute();
		// 这里还没处理
		$stmt->fetch();
		$stmt->close();	 
    	$con->close();
	}

	return $ret;
}
