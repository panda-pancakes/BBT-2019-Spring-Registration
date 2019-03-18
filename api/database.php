<?php
require_once("../config.php");

function query($info) {
	$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$con->set_charset('utf8');
	
	if ($con->connect_error) {
		return -2;
	}

	$sql = "select name, sex, tel, grade, college, dorm, department, alternative, adjustment, introduction, information from application where name = ? && tel = ?";

	$ret = new StdClass();

	$stmt = $con->prepare($sql);
	$stmt->bind_param("ss", $info["name"], $info["tel"]);
	$stmt->execute();
	$stmt->bind_result($ret->name, $ret->sex, $ret->tel, $ret->grade, $ret->college, $ret->dorm, $ret->department, $ret->alternative, $ret->adjustment, $ret->introduction, $ret->information);
	var_dump($ret->name);
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

	$data = query($info);

	if ($data->name) {
		if ($cover) {
			$sql = "update application set sex = ?, grade = ?, college = ?, dorm = ?, department = ?, alternative = ?, adjustment = ?, introduction = ? where name = ? && tel = ?";
			$stmt = $con->prepare($sql);
			$stmt->bind_param("ssssssssss", $info["sex"], $info["grade"], $info["college"], $info["dorm"], $info["department"], $info["alternative"], $info["adjustment"], $info["introduction"]);
			$stmt->execute();
			$stmt->close();
		} else {
			$con->close();
			return -1;
		}
	} else {
		$sql = "insert into application (name, sex, tel, grade, college, dorm, department, alternative, adjustment, introduction) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = $con->prepare($sql);
		$stmt->bind_param("ssssssssss", $info["name"], $info["sex"], $info["tel"], $info["grade"], $info["college"], $info["dorm"], $info["department"], $info["alternative"], $info["adjustment"], $info["introduction"]);
		$stmt->execute();
		$stmt->close();
	}

	$con->close();
	// TODO: check if success

	return 0;
}

function admin_login($username, $passwd) {	
	$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$con->set_charset('utf8');
	if ($con->connect_error) {
		return -2;
	} else {
		//$enc_pwd = md5($passwd);
		$stmt = $con->prepare("select permission from admin where username=? and password=?");
		$stmt->bind_param("ss", $username, $passwd);
		$stmt->execute();
		$stmt->bind_result($ret);
		$stmt->fetch();
		$stmt->close();
		$con->close();

		return isset($ret) ? $ret : -1;
	}
}
//登录已完成


function admin_query($permission) {
	//var_dump($permission);
	$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$con->set_charset('utf8');
	if($con->connect_error){
		return -2;

	} else {	
		if ($permission == 0) {
			$dat = $con->query("select * from application");
			//$stmt = $con->prepare("select * from application");
		} else {
			$dat = $con->query("select * from application where department = " . $permission);
			//$stmt = $con->prepare("select * from application where department = ?");
			//$stmt->bind_param("s",$permission);
		}
		//$stmt->execute();
		$ret = new stdClass();
		$array = [];
		//$stmt->bind_result($ret->name, $ret->sex, $ret->tel, $ret->grade, $ret->college, $ret->dorm, $ret->department, $ret->alternative, $ret->adjustment, $ret->introduction,$ret->timestamp, $ret->information,$ret->note);
		while($row = $dat->fetch_assoc()){
			$array[]=[
				"name" => $row["name"],
				"sex" => $row["sex"],
				"tel" =>$row["tel"],
				"grade" => $row["grade"],
				"college" => $row["college"],
				"dorm" => $row["dorm"],
				"department"=> $row["department"],
				"alternative"=>$row["alternative"],
				"adjustment"=>$row["adjustment"],
				"introduction"=>$row["introduction"],
			];
		}
		//$stmt->close();	 
    	$con->close();
	}

	return $array;
}
function change_department($value){

	$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$con->set_charset('utf8');
	if($con->connect_error){
		return -2;
	}else{
		if($value == 0){
			$stmt = $con->prepare("select * from application");
		}else{
			$stmt = $con->prepare("select * from application where department = ?");
			$stmt->bind_param("i",$value);
		}
		$stmt->execute();
		$ret = new stdClass();
		$stmt->bind_result($ret->name, $ret->sex, $ret->tel, $ret->grade, $ret->college, $ret->dorm, $ret->department, $ret->alternative, $ret->adjustment, $ret->introduction,$ret->timestamp, $ret->information,$ret->note);
		$stmt->fetch();
		$stmt->close();
		$con->close();
	}
	return $ret;
}