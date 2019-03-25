<?php
require_once("database.php");

function onQuery($arg) {
	$ret = new stdClass();
	
	$sta = query($arg);
	
	if ($sta === -2) {
		$ret->errcode = 500;
		$ret->errmsg = "Database issue";
	} elseif ($ret->exist = isset($sta->name)) {
		$ret->info = $sta;
	}
	
	return $ret;
}

registerMethod("query", onQuery, array(
	"required" => array("name", "tel")
));

/*
$functionRegistry = {
	"onSignup": {
		"required"
		"name", "sex"
	}
	
}

$parameterRegistry = {
	
}

if (!isset($_GET["method"])) {
	$ret->errcode = 400;
	$ret->errmsg = "Missing parameter: method";
} elseif (!isset($functionRegistry[$_GET["method"]])) {
	$ret->errcode = 401;
	$ret->errmsg = "Unregistered method";	
} else {
	
}

} elseif ($_GET["method"] == "signup") {	
	if (empty($data["name"])) {
		$ret->errmsg = "Missing parameter: name";

	} elseif (empty($data["sex"])) {
		$ret->errmsg = "Missing parameter: sex";
		// check 

	}elseif (empty($data["tel"])) {
		$ret->errmsg = "Missing parameter: tel";
		// check 

	}elseif (empty($data["grade"])) {
		$ret->errmsg = "Missing parameter: grade";
		// check 

	}elseif (empty($data["college"])) {
		$ret->errmsg = "Missing parameter: college";
		// check 

	}elseif (empty($data["dorm"])) {
		$ret->errmsg = "Missing parameter: dorm";
		// check 

	}
	 elseif (empty($data["department"])) {
		$ret->errmsg = "Missing parameter: department";
		// check 

	} elseif (empty($data["adjustment"])) {
		$ret->errmsg = "Missing parameter: adjustment";
		// check 
	} elseif (preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/", $data["name"])) {
		$ret->errmsg = "special characters in name";

	} elseif (!is_numeric($data["tel"]) || $data["tel"][0] != 1 || strlen($data["tel"]) != 11) {
		$ret->errmsg = "wrong telephone information";

	} elseif($data["department"] == $data["alternative"]){
		$ret->errmsg = "department can't be the same as alternative";

	}elseif (!empty($data["introduction"]) && mb_strlen($data["introduction"]) >= 50) {
		$ret->errmsg = "length of introduction limit exceeded";
	
	}else {
		if(isset($data["cover"])){
			$info = array(
				"query_name" => $_SESSION["name"],
				"query_tel" => $_SESSION["tel"],
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
		}else{
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
		}
		$sta = signup($info, isset($data["cover"]) ? $data["cover"] : false);

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
	} elseif (!is_numeric($data["tel"]) || $data["tel"][0] != 1 || strlen($data["tel"]) != 11) {
		$ret->errmsg = "wrong telephone information";
	} else {
		
		$info = array(
			"name" => $data["name"],
			"tel" => $data["tel"],
		);
		
		$_SESSION["name"] = $data["name"];
		$_SESSION["tel"] = $data["tel"];
		
		$sta = query($info);

		if ($sta === -2) {
			$ret->errmsg = "database issue";
		} else {
			$ret->exist = isset($sta->name);
			if ($ret->exist) {
				//获取不到$sta->info,因为数据是存在$sta里面的
				$ret->info = $sta;
			} else {
				$ret->errmsg = "no infomation";
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
			$ret->errcode = 0;
		} elseif ($status == -2) {
			$ret->errmsg = "database issue";
		} else {
			$ret->errmsg = "Either this account doesn't exist or the password is incorrect.";
		}
	}
} elseif ($_GET["method"] == "admin_query") {
	if (isset($_SESSION["permission"])) {
		$ret->permission = $_SESSION['permission'];
		$ret->data = admin_query($_SESSION["permission"]);
		$ret->sum = count((array)$ret->data);
	} else {
		$ret->errcode = -1;
		$ret->errmsg = "Please login first";
	}
} elseif ($_GET['method'] == "change_department") {
	if (!isset($_GET['value'])) {
		$ret->errmsg = "Please select the department.";
	} elseif ($_GET['value'] == 666) {
		$ret->data = admin_query($_SESSION["permission"]);
		$ret->sum = count((array)$ret->data);
	} else {
		$ret->data = change_department($_GET['value']);
		$ret->sum = count((array)$ret->data);
	}
} else {
	$ret->errcode = -1;
	$ret->errmsg = "Unspecified Method";
}

$ret->status = isset($ret->errmsg) ? "failed" : "ok";

echo json_encode($ret);
*/
