<?php
header("Content-Type: application/json");

include("database.php");

session_start();

$ret = new StdClass(); 
$data = file_get_contents('php://input');
$data = json_decode($data, true); 

if (!isset($_GET["method"])) {
	$ret->errmsg = "Missing parameter: method";

} elseif ($_GET["method"] == "signup") {
	if(isset($data["tel"])){
		$NumTel = strlen($data["tel"]);
		$IsNum = is_numeric($data["tel"]);
	}
	
	if (!isset($data["name"])) {
		$ret->errmsg = "Missing parameter: name";

	} elseif (!isset($data["sex"])) {
		$ret->errmsg = "Missing parameter: sex";
		// check 

	}elseif (!isset($data["tel"])) {
		$ret->errmsg = "Missing parameter: tel";
		// check 

	}elseif (!isset($data["grade"])) {
		$ret->errmsg = "Missing parameter: grade";
		// check 

	}elseif (!isset($data["college"])) {
		$ret->errmsg = "Missing parameter: college";
		// check 

	}elseif (!isset($data["dorm"])) {
		$ret->errmsg = "Missing parameter: dorm";
		// check 

	}
	 elseif (!isset($data["department"])) {
		$ret->errmsg = "Missing parameter: department";
		// check 

	} elseif (!isset($data["adjustment"])) {
		$ret->errmsg = "Missing parameter: adjustment";
		// check 

	} elseif (preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/", $data["name"])) {
		$ret->errmsg = "special characters in name";

	} elseif (!is_numeric($data["tel"]) || $data["tel"][0] != 1 || $NumTel != 11) {
		$ret->errmsg = "wrong telephone information";

	} elseif (isset($data["introduction"])) {
		if(mb_strlen($data["introduction"]) >= 50){
			$ret->errmsg = "length of introduction limit exceeded";
		}
	}else {
		$info = array(
			"name" => $data["name"],
			"sex" => $data["sex"],
			"tel" => $data["tel"],
			"grade" => $data["grade"],
			"college" => $data["college"],
			"dorm" => $data["dorm"],
			"department" => $data["department"],
			"alternative" => $data["alternative"],
			"adjustment" => $data["adjustment"],
			"introduction" => $data["introduction"],
		);

		$sta = signup($info, $_POST["cover"]);

		if ($sta == -1) {
			$ret->errmsg = "existed";
		} elseif ($sta == -2) {
			$ret->errmsg = "database issue";
		}
	}

} elseif ($_GET["method"] == "query") {
	if (!isset($data["name"])) {
		$ret->errmsg = "Missing parameter: name";

	} elseif (!isset($data["tel"])) {
		$ret->errmsg = "Missing parameter: tel";
		// check 
	} else {
		$sta = query($info);
		if ($sta == -2) {
			$ret->errmsg = "database issue";
		} else {
			$ret->exist = isset($sta->name);
			if ($ret->exist) {
				$ret->info = $sta->info;
			}
		}
	}
	 
} 
elseif ($_GET["method"] == "admin_login") {
	if (!isset($_POST["username"])) {
		$ret->errmsg = "Missing parameter: username";
	} elseif (!isset($_POST["password"])) {
		$ret->errmsg = "Missing parameter: password";
	} elseif (preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/", $username)) {
		$ret->errmsg = "It's not allowed to use special characters in username.";
	} else {
		$status = admin_login($_POST["username"], $_POST["password"]);
		if ($status >= 0) {
			$_SESSION["username"] = $_POST["username"];
			$_SESSION["permission"] = $status;
		} elseif ($status == -2) {
			$ret->errmsg = "database issue";
		} elseif ($status == -3) {
			$ret->errmsg = "Either this account doesn't exist or the password is incorrect.";
		}
	}

} elseif ($_GET["method"] == "admin_query") {
	if(empty($_POST["department"])){
		$ret->errmsg = "请输入部门名称";
	}elseif(empty($_POST["password"])){
		$ret->errmsg = "请输入密码";
	}else{
		$check = admin_query($_POST["department"]);
		if($check == 1){
			$ret->errmsg = "用户名或密码错误";
		}elseif($check == 2){
			$ret->errmsg = "用户名或密码错误";
		}elseif($check == -2){
			$ret->errmsg = "数据库繁忙，请稍后再试";
		}elseif($check == 0){
			$ret->errmsg = "登录成功";
		}
	}
	

} else {
	$ret->errmsg = "Unspecified Method";
}

$ret->status = isset($ret->errmsg) ? "failed" : "ok";

echo json_encode($ret);