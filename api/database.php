<?php
require_once("../config.php");

function query($info) {
	$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$con->set_charset('utf8mb4');

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
	$con->set_charset('utf8mb4');
	if ($con->connect_error) {
		return -2;
	}
	
	$data = query($info);

	if (isset($info["query_name"]) && isset($info["query_tel"]) && $info["query_name"] && $info["query_tel"]) {
		if ($cover) {
			$sql = "update application set name = ?, tel = ?, sex = ?, grade = ?, college = ?, dorm = ?, department = ?, alternative = ?, adjustment = ?, introduction = ? where name = ? && tel = ?";
			$stmt = $con->prepare($sql);
			$stmt->bind_param("ssssssssssss", $info["name"], $info["tel"], $info["sex"], $info["grade"], $info["college"], $info["dorm"], $info["department"], $info["alternative"], $info["adjustment"] ? 1 : 0, $info["introduction"], $info["query_name"], $info["query_tel"]);
			$stmt->execute();
			$stmt->close();
		} else {
			$con->close();
			return -1;
		}
	}elseif($data->name && $data->tel){
		$con->close();
		return -1;
	} else {
		$sql = "insert into application (name, sex, tel, grade, college, dorm, department, alternative, adjustment, introduction) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = $con->prepare($sql);
		$stmt->bind_param("ssssssssss", $info["name"], $info["sex"], $info["tel"], $info["grade"], $info["college"], $info["dorm"], $info["department"], $info["alternative"], $info["adjustment"] ? 1 : 0, $info["introduction"]);
		if (!$stmt->execute()) {
			$err_msg = $stmt->error;
			$stmt->close();
			return $err_msg;
		}
		$stmt->close();
	}

	$con->close();
	// TODO: check if success

	return 0;
}

function admin_login($username, $passwd) {
	$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$con->set_charset('utf8mb4');
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
	$con->set_charset('utf8mb4');
	if ($con->connect_error) {
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
		$array = [];
		//$stmt->bind_result($ret->name, $ret->sex, $ret->tel, $ret->grade, $ret->college, $ret->dorm, $ret->department, $ret->alternative, $ret->adjustment, $ret->introduction,$ret->timestamp, $ret->information,$ret->note);
		while ($row = $dat->fetch_assoc()) {
			$array[] = [
				"name" => $row["name"],
				"sex" => StrToSex($row["sex"]),
				"tel" => $row["tel"],
				"grade" => $row["grade"],
				"college" => NumToCollege($row["college"]),
				"dorm" => $row["dorm"],
				"department" => NumToDep($row["department"]),
				"alternative" => NumToDep($row["alternative"]),
				"adjustment" => Ajustment($row["adjustment"]),
				"introduction" => $row["introduction"],
			];
		}
		//$stmt->close();	 
		$con->close();
	}

	return $array;
}
function change_department($value) {

	$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$con->set_charset('utf8mb4');
	if ($con->connect_error) {
		return -2;
	} else {

		$dat = $con->query("select * from application where department = " . $value);
		//	$stmt = $con->prepare("select * from application where department = ?");
		//	$stmt->bind_param("i",$value);
		$array = [];
		//$stmt->bind_result($ret->name, $ret->sex, $ret->tel, $ret->grade, $ret->college, $ret->dorm, $ret->department, $ret->alternative, $ret->adjustment, $ret->introduction,$ret->timestamp, $ret->information,$ret->note);
		while ($row = $dat->fetch_assoc()) {
			$array[] = [
				"name" => $row["name"],
				"sex" => StrToSex($row["sex"]),
				"tel" => $row["tel"],
				"grade" => $row["grade"],
				"college" => NumToCollege($row["college"]),
				"dorm" => $row["dorm"],
				"department" => NumToDep($row["department"]),
				"alternative" => NumToDep($row["alternative"]),
				"adjustment" => Ajustment($row["adjustment"]),
				"introduction" => $row["introduction"],
			];
		}
	}
	return $array;
}

function NumToCollege($val) {
	switch ($val) {
		case 0:
			$val = "机械与汽车工程学院";
			break;
		case 1:
			$val = "建筑学院";
			break;
		case 2:
			$val = "土木与交通学院";
			break;
		case 3:
			$val = "电子与信息学院";
			break;
		case 4:
			$val = "材料科学与工程学院";
			break;
		case 5:
			$val = "化学与化工学院";
			break;
		case 6:
			$val = "轻工科学与工程学院";
			break;
		case 7:
			$val = "食品科学与工程学院";
			break;
		case 8:
			$val = "数学学院";
			break;
		case 9:
			$val = "物理与光电学院";
			break;
		case 10:
			$val = "经济与贸易学院";
			break;
		case 11:
			$val = "自动化科学与工程学院";
			break;
		case 12:
			$val = "计算机科学与工程学院";
			break;
		case 13:
			$val = "电力学院";
			break;
		case 14:
			$val = "生物科学与工程学院";
			break;
		case 15:
			$val = "环境与能源学院";
			break;
		case 16:
			$val = "软件学院";
			break;
		case 17;
			$val = "工商管理学院";
			break;
		case 18:
			$val = "公共管理学院";
			break;
		case 19:
			$val = "马克思主义学院";
			break;
		case 20:
			$val = "外国语学院";
			break;
		case 21:
			$val = "法学院";
			break;
		case 22:
			$val = "新闻与传播学院";
			break;
		case 23:
			$val = "艺术学院";
			break;
		case 24:
			$val = "体育学院";
			break;
		case 25:
			$val = "设计学院";
			break;
		case 26:
			$val = "医学院";
			break;
		case 27:
			$val = "国际教育学院";
			break;
		default:
			$val = "未填写学院";
	}
	return $val;
}

function StrToSex($val)
{
	if ($val == 'M') {
		$val = "男";
	} elseif ($val == 'F') {
		$val = "女";
	} else {
		$val = "未知";
	}
	return $val;
}

function NumToDep($val)
{
	switch ($val) {
		case 0:
			$val = "技术部-代码组";
			break;
		case 1:
			$val = "技术部-设计组";
			break;
		case 2:
			$val = "技术部（北校专业）";
			break;
		case 3:
			$val = "策划推广部";
			break;
		case 4:
			$val = "编辑部-原创写手";
			break;
		case 5:
			$val = "编辑部-摄影";
			break;
		case 6:
			$val = "编辑部-可视化设计";
			break;
		case 7:
			$val = "视觉设计部";
			break;
		case 8:
			$val = "视频部-策划导演";
			break;
		case 9:
			$val = "视频部-摄影摄像";
			break;
		case 10:
			$val = "视频部-剪辑特效";
			break;
		case 11:
			$val = "外联部";
			break;
		case 12:
			$val = "节目部-国语组";
			break;
		case 13:
			$val = "节目部-英语组";
			break;
		case 14:
			$val = "节目部-粤语组";
			break;
		case 15:
			$val = "人力资源部";
			break;
		case 16:
			$val = "综合管理部-行政管理";
			break;
		case 17:
			$val = "综合管理部-物资财物";
			break;
		case 18:
			$val = "综合管理部-撰文记者";
			break;
		case 19:
			$val = "综合管理部-摄影记者";
			break;
		case 20:
			$val = "产品运营部（北校专业）";
			break;
		default:
			$val = "未填写报名志愿";
	}
	return $val;
}

function Ajustment($val)
{
	if ($val == 0) {
		$val = "是";
	} elseif ($val == 1) {
		$val = "否";
	} else {
		$val = "未填写";
	}
	return $val;
}

