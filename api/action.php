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

	} elseif (!is_numeric($data["tel"]) || $data["tel"][0] != 1 || strlen($data["tel"]) != 11) {
		$ret->errmsg = "wrong telephone information";

	} elseif (!empty($data["introduction"]) && mb_strlen($data["introduction"]) >= 50) {
		$ret->errmsg = "length of introduction limit exceeded";
	
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

		$sta = signup($info, isset($_POST["cover"]) ? $_POST["cover"] : false);

		if ($sta == -1) {
			$ret->errmsg = "existed";
		} elseif ($sta == -2) {
			$ret->errmsg = "database issue";
		}
	}

} elseif ($_GET["method"] == "query") {
	if (empty($data["name"])) {
		$ret->errmsg = "Missing parameter: name";

	} elseif (empty($data["tel"])) {
		$ret->errmsg = "Missing parameter: tel";
		// check 
	}elseif (!is_numeric($data["tel"]) || $data["tel"][0] != 1 || strlen($data["tel"]) != 11) {
		$ret->errmsg = "wrong telephone information";

	} else {
		$info = array(
			"name" => $data["name"],
			"tel" => $data["tel"],
		);

		$sta = query($info);

		if ($sta === -2) {
			$ret->errmsg = "database issue";
			
		} else {
			$ret->exist = isset($sta->name);
			if ($ret->exist) {
				$ret->info = $sta->info;

			} else {
				$ret->errcode = "233";
			}
		}
	}
	 
} elseif ($_GET["method"] == "admin_login") {
	if (empty($_POST["department"])) {
		$ret->errmsg = "Missing parameter: department";

	} elseif (empty($_POST["password"])) {
		$ret->errmsg = "Missing parameter: password";

	} elseif (preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/", $_POST['department'])) {
		$ret->errmsg = "It's not allowed to use special characters in username.";

	} else {
		$status = admin_login($_POST["department"], $_POST["password"]);
		if ($status >= 0) {
			$_SESSION["department"] = $_POST["department"];
			$_SESSION["permission"] = $status;
		} elseif ($status == -2) {
			$ret->errmsg = "database issue";
		} else {
			$ret->errmsg = "Either this account doesn't exist or the password is incorrect.";
		}
	}

} elseif ($_GET["method"] == "admin_query") {
	if (isset($_SESSION["permission"])) {
		$ret->$data = admin_query($_SESSION["permission"]);

	} else {
		$ret->errmsg = "Please login first";
	}

} else {
	$ret->errmsg = "Unspecified Method";
}

$ret->status = isset($ret->errmsg) ? "failed" : "ok";

echo json_encode($ret);