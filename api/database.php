<?php
require_once("../config.php");

function query($info) {
	$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	
	if ($con->connect_error) {
		return -2;
	}
	$sql = "select name, tel, information from application where name = ? && tel = ?";

	$ret = new StdClass();

	$stmt = $con->prepare($sql);
	$stmt->bind_param("ss", $info["name"], $info["tel"]);
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
	$enc_user = md5($username);
	$enc_pwd = md5($passwd);
	$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	if ($con->connect_error) {
		return -2;
	}else{
	$stmt = $con->prepare("select * from admin where department=? and password=?");
	$stmt->bind_param("ss",$enc_user,$enc_pwd);	
	if ($stmt->execute()) {
		if (false == $stmt->get_result() or null == $stmt->get_result()) {
			return -1;
		}elseif($enc_user == "南校技术部"){
			return 1;                       //可查询所有报名名单
		}else{
			return 0;                       //只可查询本部门名单
		}
	}else{
		var_dump("false");
	}
}
	$stmt->close();
	$con->close();
}


function admin_query($permission) {

	$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if($con->connect_error){
		return -2;
		exit();
	}else{	
		if($permission != 1){
			return -1;
		}else{
			$stmt = $con->prepare("select * from applicants");
			 $ret = new StdClass();
			 $stmt->execute();
			 $stmt->bind_result($ret->name,$ret->sex,$ret->college,$ret->grade,$ret->tel,$ret->dorm,$ret->Choiceone,$ret->Choicetwo,$ret->adjust,$ret->info);
			 $stmt->fetch();
			 $stmt->close();
			 $con->close();		
			 return $ret;		 

		}
	}

function user_query($department){
	$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if($con->connect_error){
		return -2;
		exit();
	}else{
		$stmt = $con->prepare("select * from applicants where ChoiceOne = ? or ChoiceTwo = ?");
		$stmt->bind_param("ss",$department,$department);
		$ret = new stdClass();
		$stmt->execute();
		$stmt->bind_result($ret->name,$ret->sex,$ret->college,$ret->grade,$ret->tel,$ret->dorm,$ret->Choiceone,$ret->Choicetwo,$ret->adjust,$ret->info);
		$stmt->fetch();
		$stmt->close();
		$con->close();		
		return $ret;		 
}
}


















    $con->close();
	return $ret;
}
