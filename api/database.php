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


function admin_query($department) {

 	$ret = new StdClass();
	$conn = new mysqli('localhost', 'root', '', 'registration');
	if($conn->connect_error){
		return -2;
		exit();
	}else{	
	$stmt = $conn->prepare("select password from admin where department = ?");
	$stmt->bind_param("s",$department);
	if($stmt->execute()){
	  if($result = $stmt->get_result()){
		  while($result->fetch_array(MYSQLI_NUM) = 0){
			  return 1;
		  }
    }else{
		return 2;
		printf("无法获取结果");
	}
	}else{
		printf("无法正确执行语句");
	}

	$stmt->close();
	/*if($res == false){
		return 1;
	}
*/
	return 0;
	}



















    $conn->close();
	return $ret;
}
