<?php
header("Content-Type: application/json");

include("database.php");

session_start();

$ret = new StdClass(); 

if (!isset($_GET["method"])) {
	$ret->errmsg = "Missing parameter: method";

} elseif ($_GET["method"] == "signup") {
	if(isset($_POST["tel"])){
		$NumTel = strlen($tel);
		$IsNum = is_numeric($tel)?true:false;
	}
	
	
	if (!isset($_POST["name"])) {
		$ret->errmsg = "Missing parameter: name";

	} elseif (!isset($_POST["sex"])) {
		$ret->errmsg = "Missing parameter: sex";
		// check 

	}elseif (!isset($_POST["tel"])) {
		$ret->errmsg = "Missing parameter: tel";
		// check 

	}elseif (!isset($_POST["grade"])) {
		$ret->errmsg = "Missing parameter: grade";
		// check 

	}elseif (!isset($_POST["college"])) {
		$ret->errmsg = "Missing parameter: college";
		// check 

	}elseif (!isset($_POST["dorm"])) {
		$ret->errmsg = "Missing parameter: dorm";
		// check 

	}
	 elseif (!isset($_POST["department"])) {
		$ret->errmsg = "Missing parameter: department";
		// check 

	} elseif (!isset($_POST["adjustment"])) {
		$ret->errmsg = "Missing parameter: adjustment";
		// check 

	} elseif (preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/", $name)) {
		$ret->errmsg = "special characters in name";

	} elseif ($IsNum == false || $tel[0] != 1 || $NumTel != 11){
		$ret->errmsg = "wrong teliphone information";

	} elseif (isset($_POST["introduction"])){
		$IntroLength = mb_strlen($introduction);
		if($IntroLength >=50){
			$ret->errmsg = "length of introduction limit exceeded";
		}
	}else {
		$info = array(
			"name" => $_POST["name"],
			"sex" => $_POST["sex"],
			"tel" => $_POST["tel"],
			"grade" => $_POST["grade"],
			"college" => $_POST["college"],
			"dorm" => $_POST["dorm"],
			"department" => $_POST["department"],
			"alternative" => $_POST["alternative"],
			"adjustment" => $_POST["adjustment"],
			"introduction" => $_POST["introduction"],
		);

		$sta = signup($info, $_POST["cover"]);

		if ($sta == -1) {
			$ret->errmsg = "existed";
		} elseif ($sta == -2) {
			$ret->errmsg = "database issue";
		}
	}

} elseif ($_GET["method"] == "query") {
	if (!isset($_POST["name"])) {
		$ret->errmsg = "Missing parameter: name";

	} elseif (!isset($_POST["tel"])) {
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
	 
} elseif ($_GET["method"] == "admin_login") {
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
	

} else {
	$ret->errmsg = "Unspecified Method";
}

$ret->status = isset($ret->errmsg) ? "failed" : "ok";

echo json_encode($ret);